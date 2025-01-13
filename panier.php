<?php
session_start();
$couleurs = [
    "#FFFFFF" => "Blanc",
    "#000000" => "Noir",
    "#FF0000" => "Rouge",
    "#00FF00" => "Vert",
    "#0000FF" => "Bleu",
    "#FFFF00" => "Jaune",
    "#FFA500" => "Orange",
    "#800080" => "Violet",
    "#808080" => "Gris",
    "#A52A2A" => "Marron",
    "#FFC0CB" => "Rose",
    "#ADD8E6" => "Bleu clair",
    "#F5F5DC" => "Beige",
    "#C0C0C0" => "Argent",
    "#FFD700" => "Or",
    "#008000" => "Vert foncé",
    "#8B0000" => "Rouge foncé",
    "#4B0082" => "Indigo",
    "#00FFFF" => "Cyan",
    "#F0E68C" => "Kaki",
    "#D3D3D3" => "Gris clair",
    "#B22222" => "Rouge brique",
    "#FFE4C4" => "Bisque (Beige rosé)",
    "#00008B" => "Bleu marine",
    "#696969" => "Gris foncé"
];
$knownTitles = [
    "index.html" => "Accueil",
    "vetement_all.php"=> "Vêtement",
    "vetement_hommme.php"=> "Homme",
    "vetement_femme.php"=>"Femme",
    "vetement_enfant"=>"Enfant",
    "produit.php" => "Produits",
    "contact.php" => "Contact",
    "panier.php" => "Votre Panier",
];

$previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
$previousPageName = $previousPage ? basename(parse_url($previousPage, PHP_URL_PATH)) : null;
$previousPageTitle = $previousPageName && isset($knownTitles[$previousPageName]) ? $knownTitles[$previousPageName] : null;


// Initialiser le panier si ce n'est pas encore fait
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Gérer l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_name'], $_POST['product_price'], $_POST['product_color'], $_POST['product_size'], $_POST['quantity'])) {
        $productBrand = $_POST['product_brand'] ?? 'Marque inconnue'; // Valeur par défaut si la marque n'est pas définie
        $productName = $_POST['product_name'];
        $productPrice = (float)$_POST['product_price'];
        $productColor = $_POST['product_color'];
        $productSize = $_POST['product_size'];
        $productQuantity = (int)$_POST['quantity'];

        // Vérifier si le produit existe déjà dans le panier
        $found = false;
        foreach ($_SESSION['cart'] as $index => &$product) {
            if ($product['name'] === $productName && $product['size'] === $productSize && $product['color'] === $productColor) {
                $product['quantity'] += $productQuantity;
                $_SESSION['last_added'] = $index; // Mettre à jour l'index du dernier produit ajouté
                $found = true;
                break;
            }
        }
        unset($product);

        // Si le produit n'existe pas dans le panier, l'ajouter
        if (!$found) {
            $_SESSION['cart'][] = [
                'brand' => $productBrand,
                'name' => $productName,
                'price' => $productPrice,
                'color' => $productColor,
                'size' => $productSize,
                'quantity' => $productQuantity,
            ];
            $_SESSION['last_added'] = array_key_last($_SESSION['cart']); // Mettre à jour l'index du dernier produit ajouté
        }

        // Redirection pour éviter la soumission multiple
        header("Location: panier.php");
        exit;
    }
}

// Gérer la modification ou suppression d'un produit
foreach ($_POST as $key => $value) {
    if (preg_match('/^decrease_(\d+)$/', $key, $matches)) {
        $index = (int)$matches[1];
        if ($_SESSION['cart'][$index]['quantity'] > 1) {
            $_SESSION['cart'][$index]['quantity']--;
        } else {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Réindexation
        }
    } elseif (preg_match('/^increase_(\d+)$/', $key, $matches)) {
        $index = (int)$matches[1];
        $_SESSION['cart'][$index]['quantity']++;
    } elseif (preg_match('/^remove_(\d+)$/', $key, $matches)) {
        $index = (int)$matches[1];
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Réindexation
        // Si le dernier produit ajouté est supprimé, réinitialiser last_added
        if (isset($_SESSION['last_added']) && $_SESSION['last_added'] == $index) {
            unset($_SESSION['last_added']);
        }
    }
}

// Réinitialiser last_added si le panier est vide ou l'index n'est plus valide
if (empty($_SESSION['cart']) || !isset($_SESSION['cart'][$_SESSION['last_added']])) {
    unset($_SESSION['last_added']);
}

// Calculer le prix total
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panier</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/panier.css">
    <link rel="stylesheet" href="./assets/css/global/header-bis.css">

</head>

<body>
    <header class="header">
        <a href="index.html" class="logo"><img src="./assets/img/logo/logo.png" alt="Logo Kaizen" />Kaizen</a>
    </header>
    <nav class="breadcrumb">
        <a href="index.html">Accueil</a>
        <span>&gt;</span>
        <?php if ($previousPage): ?>
        <a href="<?= htmlspecialchars($previousPage) ?>"
            class="return-btn"><?= htmlspecialchars($previousPageTitle) ?></a>
        <?php endif; ?>
        <span>&gt;</span>
        <a href="panier.php">Panier</a>
    </nav>
    <div class="progress">
        <div class="active">1. Panier</div>
        <div>2. Livraison</div>
        <div>3. Paiement</div>
    </div>
    <div class="container">
        <div class="cart">
            <div class="cart-content">
                <div class="cart-items">
                    <?php
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $index => $product) {
                            $itemTotal = $product['quantity'] * $product['price'];
                            $totalPrice += $itemTotal;
                    ?>
                    <div class="cart-item">
                        <div class="item-details">
                            <p><strong>Produit :</strong> <?= htmlspecialchars($product['name']) ?></p>
                            <p><strong>Taille :</strong> <?= htmlspecialchars($product['size']) ?></p>
                            <p><strong>Couleur :</strong>
                                <?= isset($couleurs[$product['color']]) ? $couleurs[$product['color']] : "Couleur inconnue" ?>
                            </p>
                        </div>
                        <div class="item-actions">
                            <form method="post" style="display: flex; align-items: center; gap: 5px;">
                                <button type="submit" name="decrease_<?= $index ?>">-</button>
                                <input type="number" value="<?= $product['quantity'] ?>" disabled />
                                <button type="submit" name="increase_<?= $index ?>">+</button>
                                <button type="submit" name="remove_<?= $index ?>"
                                    style="background-color: red; color: white;">
                                    Supprimer
                                </button>
                            </form>
                            <span class="item-price">
                                <?= number_format($itemTotal, 2) ?> €
                            </span>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo "<p>Votre panier est vide.</p>";
                    }
                    ?>
                </div>
                <div class="summary">
                    <p><strong>Nombre de produits :</strong> <?= count($_SESSION['cart']) ?></p>
                    <p><strong>Total :</strong> <?= number_format($totalPrice, 2) ?> €</p>
                    <p><strong>Livraison :</strong> Gratuit</p>
                    <button>Poursuivre la commande</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-settings">
            <div class="language-selector">
                <label for="language">Langue :</label>
                <select id="language" name="language">
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                </select>
            </div>
            <div class="vision-mode-toggle">
                <label for="vision-mode">Mode malvoyant :</label>
                <button id="vision-mode">Activer</button>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-section">
                <input type="checkbox" id="discover" class="toggle" />
                <label for="discover">Notre entreprise <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Notre entreprise</h2>
                    <li><a href="temporaire.html">Qui sommes-nous ?</a></li>
                    <li><a href="temporaire.html">La vie de nos produits</a></li>
                    <li><a href="temporaire.html">Engagement durable</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="help" class="toggle" />
                <label for="help">Besoin d'aide <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Besoin d'aide</h2>
                    <li><a href="temporaire.html">Mode de livraison</a></li>
                    <li><a href="temporaire.html">Moyens de paiement</a></li>
                    <li><a href="temporaire.html">Comment choisir votre produit</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="sport" class="toggle" />
                <label for="sport">Faire du sport <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Faire du sport</h2>
                    <li><a href="tutoriel.html">Tutoriels</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="follow" class="toggle" />
                <label for="follow">Suivez-nous <span>˅</span></label>
                <div class="content social-media">
                    <a href="temporaire.html" class="social-icon facebook">
                        <svg width="21" height="21" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z"
                                fill="currentColor" />
                        </svg>
                        Facebook
                    </a>
                    <a href="temporaire.html" class="social-icon instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="21" height="21">
                            <path
                                d="M7.75 2H16.25C19.35 2 22 4.65 22 7.75V16.25C22 19.35 19.35 22 16.25 22H7.75C4.65 22 2 19.35 2 16.25V7.75C2 4.65 4.65 2 7.75 2ZM7.75 4C5.68 4 4 5.68 4 7.75V16.25C4 18.32 5.68 20 7.75 20H16.25C18.32 20 20 18.32 20 16.25V7.75C20 5.68 18.32 4 16.25 4H7.75ZM12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9ZM17.5 6C18.33 6 19 6.67 19 7.5C19 8.33 18.33 9 17.5 9C16.67 9 16 8.33 16 7.5C16 6.67 16.67 6 17.5 6Z"
                                fill="currentColor" />
                        </svg>
                        Instagram
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom-container">
            <div class="footer-bottom">
                <h3>&copy; 2024 Kaizen - Tous droits réservés.</h3>
            </div>
            <div class="footer-bottom-link">
                <ul>
                    <li><a href="temporaire.html">Transparence des produit</a></li>
                    <li><a href="temporaire.html">Condition Générales</a></li>
                    <li><a href="temporaire.html">Mention légales</a></li>
                    <li><a href="temporaire.html">Données personnelles</a></li>
                    <li><a href="temporaire.html">Gestion des cookies</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>
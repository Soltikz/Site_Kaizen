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
    "#696969" => "Gris foncé",
    "#87CEEB" => "Bleu ciel",
    "#2E8B57" => "Vert séquoia",
    "#FF6347" => "Tomate",
    "#DA70D6" => "Orchidée",
    "#EEE8AA" => "Jaune pâle",
    "#98FB98" => "Vert pâle",
    "#4682B4" => "Bleu acier",
    "#FF4500" => "Orange rouge",
    "#8A2BE2" => "Bleu violet",
    "#7FFF00" => "Vert chartreuse",
    "#D2691E" => "Chocolat",
    "#6495ED" => "Bleu cornflower",
    "#DC143C" => "Cramoisi",
    "#00CED1" => "Turquoise foncé",
    "#9400D3" => "Violet foncé",
    "#556B2F" => "Vert olive foncé",
    "#FF8C00" => "Orange foncé",
    "#9932CC" => "Violet foncé",
    "#E9967A" => "Saumon foncé",
    "#8FBC8F" => "Vert océan",
    "#483D8B" => "Bleu ardoise foncé",
    "#2F4F4F" => "Gris ardoise foncé",
    "#FF1493" => "Rose profond",
    "#00BFFF" => "Bleu ciel profond",
    "#1E90FF" => "Bleu dodger",
    "#BDB76B" => "Kaki foncé",
    "#CD5C5C" => "Rouge indien",
    "#7B68EE" => "Bleu ardoise moyen",
    "#FA8072" => "Saumon",
    "#FF69B4" => "Rose vif",
    "#FFE4E1" => "Rose brume",
    "#40E0D0" => "Turquoise",
    "#C71585" => "Fuchsia foncé",
    "#191970" => "Bleu minuit"
];
$knownTitles = [
    "index.php" => "Accueil",
    "vetement_all.php"=> "Vêtement",
    "vetement_hommme.php"=> "Homme",
    "vetement_femme.php"=>"Femme",
    "vetement_enfant"=>"Enfant",
    "sous-vetement_all.php"=> "Vêtement",
    "sous-vetement_hommme.php"=> "Sous-Vêtement Homme",
    "sous-vetement_femme.php"=>"Sous-Vêtement Femme",
    "sous-vetement_enfant"=>"Sous-Vêtement Enfant",
    "produit.php" => "Produits",
    "contact.php" => "Contact",
    "panier.php" => "Panier",
    "homme.php"=>"Homme",
    "femme.php"=>"Femme",
    "enfant"=>"Enfant",
    "gants-homme.php"=>"Gants Homme",
    "gants-femme.php"=>"Gants Femme",
    "gants-enfnat.php"=>"Gants Enfant",
    "chaussure-hommme.php"=>"Chaussures Homme",
    "chaussure-femme.php"=>"Chaussures Femme",
    "chaussure-enfant.php"=>"Chaussures Enfant",
    "lunette-homme"=>"Lunettes Homme",
    "lunette-femme"=>"Lunettes Femme",
    "lunette-enfant"=>"Lunettes Enfant",
    "accessoire.php"=>"Accessoires",
    "ski.php"=>'Ski',
    "snow.php"=>"Snowboard",
    "luge.php"=>"Luge",
    "raquette.php"=>"Raquette"
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

<body class="<?php echo $vision_mode_enabled ? 'vision-mode-enabled' : ''; ?>">
    <header class="header">
        <a href="index.html" class="logo">
            <img src="./assets/img/logo/logo.png" alt="Logo Kaizen" />
            Kaizen
        </a>
    </header>

    <nav class="breadcrumb">
        <a href="index.php"><?= $translations['home'] ?? 'Accueil'; ?></a>
        <span>&gt;</span>
        <?php if ($previousPage): ?>
        <a href="<?= htmlspecialchars($previousPage) ?>"
            class="return-btn"><?= htmlspecialchars($previousPageTitle) ?></a>
        <?php endif; ?>
        <span>&gt;</span>
        <a href="panier.php"><?= $translations['cart'] ?? 'Panier'; ?></a>
    </nav>

    <div class="progress">
        <div class="active"><?= $translations['step_cart'] ?? '1. Panier'; ?></div>
        <div><?= $translations['step_delivery'] ?? '2. Livraison'; ?></div>
        <div><?= $translations['step_payment'] ?? '3. Paiement'; ?></div>
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
                            <p><strong><?= $translations['product'] ?? 'Produit'; ?> :</strong>
                                <?= htmlspecialchars($product['name']) ?></p>
                            <p><strong><?= $translations['size'] ?? 'Taille'; ?> :</strong>
                                <?= htmlspecialchars($product['size']) ?></p>
                            <p><strong><?= $translations['color'] ?? 'Couleur'; ?> :</strong>
                                <?= isset($couleurs[$product['color']])
                                    ? $couleurs[$product['color']]
                                    : ($translations['unknown_color'] ?? 'Couleur inconnue'); ?>
                            </p>
                        </div>
                        <div class="item-actions">
                            <form method="post" style="display: flex; align-items: center; gap: 5px;">
                                <button type="submit" name="decrease_<?= $index ?>">-</button>
                                <input type="number" value="<?= $product['quantity'] ?>" disabled />
                                <button type="submit" name="increase_<?= $index ?>">+</button>
                                <button type="submit" name="remove_<?= $index ?>"
                                    style="background-color: red; color: white;">
                                    <?= $translations['remove'] ?? 'Supprimer'; ?>
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
                        echo "<p>" . ($translations['empty_cart'] ?? 'Votre panier est vide.') . "</p>";
                    }
                    ?>
                </div>
                <div class="summary">
                    <p><strong><?= $translations['number_of_products'] ?? 'Nombre de produits'; ?> :</strong>
                        <?= count($_SESSION['cart']) ?></p>
                    <p><strong><?= $translations['total'] ?? 'Total'; ?> :</strong>
                        <?= number_format($totalPrice, 2) ?> €</p>
                    <p><strong><?= $translations['shipping'] ?? 'Livraison'; ?> :</strong>
                        <?= $translations['free_shipping'] ?? 'Gratuit'; ?></p>
                    <button><?= $translations['continue_order'] ?? 'Poursuivre la commande'; ?></button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-settings">
            <div class="language-selector">
                <label for="language"><?= $translations['footer_language'] ?? 'Langue' ?></label>
                <form method="POST">
                    <select id="language" name="language" onchange="this.form.submit()">
                        <option value="fr" <?= $language == 'fr' ? 'selected' : '' ?>>
                            <?= $translations['language_french'] ?? 'Français' ?></option>
                        <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>
                            <?= $translations['language_english'] ?? 'English' ?></option>
                    </select>
                </form>
            </div>
            <div class="vision-mode-toggle">
                <label for="vision-mode"><?= $translations['vision_mode_label'] ?? 'Mode malvoyant :' ?></label>
                <!-- Lien pour activer/désactiver le mode malvoyant -->
                <a href="?vision_mode=true" class="vision-mode-toggle-link">
                    <?= $translations['vision_mode_activate'] ?? 'Activer' ?>
                </a>
                <a href="?vision_mode=false" class="vision-mode-toggle-link">
                    <?= $translations['vision_mode_deactivate'] ?? 'Désactiver' ?>
                </a>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-section">
                <input type="checkbox" id="discover" class="toggle" />
                <label for="discover"><?= $translations['our_company'] ?? 'Notre entreprise' ?> <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title"><?= $translations['our_company'] ?? 'Notre entreprise' ?></h2>
                    <li><a href="temporaire.html"><?= $translations['who_we_are'] ?? 'Qui sommes-nous ?' ?></a></li>
                    <li><a href="temporaire.html"><?= $translations['product_life'] ?? 'La vie de nos produits' ?></a>
                    </li>
                    <li><a
                            href="temporaire.html"><?= $translations['sustainable_commitment'] ?? 'Engagement durable' ?></a>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="help" class="toggle" />
                <label for="help"><?= $translations['need_help'] ?? 'Besoin d\'aide' ?> <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title"><?= $translations['need_help'] ?? 'Besoin d\'aide' ?></h2>
                    <li><a href="temporaire.html"><?= $translations['delivery_mode'] ?? 'Mode de livraison' ?></a></li>
                    <li><a href="temporaire.html"><?= $translations['payment_methods'] ?? 'Moyens de paiement' ?></a>
                    </li>
                    <li><a
                            href="temporaire.html"><?= $translations['product_selection'] ?? 'Comment choisir votre produit' ?></a>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="sport" class="toggle" />
                <label for="sport"><?= $translations['sport'] ?? 'Faire du sport' ?> <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title"><?= $translations['sport'] ?? 'Faire du sport' ?></h2>
                    <li><a href="tutoriel.html"><?= $translations['menu_tutorial'] ?? 'Tutoriels' ?></a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="follow" class="toggle" />
                <label for="follow"><?= $translations['follow_us'] ?? 'Suivez-nous' ?> <span>˅</span></label>
                <div class="content social-media">
                    <a href="temporaire.html" class="social-icon facebook">
                        <svg width="21" height="21" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="..." fill="currentColor" />
                        </svg>
                        <?= $translations['facebook'] ?? 'Facebook' ?>
                    </a>
                    <a href="temporaire.html" class="social-icon instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="21" height="21">
                            <path d="..." fill="currentColor" />
                        </svg>
                        <?= $translations['instagram'] ?? 'Instagram' ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom-container">
            <div class="footer-bottom">
                <h3>&copy; 2024 Kaizen - <?= $translations['all_rights_reserved'] ?? 'Tous droits réservés.' ?></h3>
            </div>
            <div class="footer-bottom-link">
                <ul>
                    <li><a
                            href="temporaire.html"><?= $translations['product_transparency'] ?? 'Transparence des produits' ?></a>
                    </li>
                    <li><a href="temporaire.html"><?= $translations['terms_conditions'] ?? 'Conditions Générales' ?></a>
                    </li>
                    <li><a href="temporaire.html"><?= $translations['legal_mentions'] ?? 'Mentions légales' ?></a></li>
                    <li><a href="temporaire.html"><?= $translations['personal_data'] ?? 'Données personnelles' ?></a>
                    </li>
                    <li><a
                            href="temporaire.html"><?= $translations['cookies_management'] ?? 'Gestion des cookies' ?></a>
                    </li>
                    <li><a href="contact.html"><?= $translations['contact'] ?? 'Contact' ?></a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>
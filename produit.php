<?php
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

include_once 'articles.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $productId = $_GET['id'];
    $product = null;

    foreach ($articles as $article) {
        if ($article['id'] == $productId) {
            $product = $article;
            break;
        }
    }
}
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.html';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/global/header-bis.css">
    <link rel="stylesheet" href="./assets/css/global/produit.css">
    <link rel="stylesheet" href="./assets/css/global/vision-mode.css">
</head>

<body class="<?php echo $vision_mode_enabled ? 'vision-mode-enabled' : ''; ?>">
    <header class="header">
        <a href="index.php" class="logo"><img src="./assets/img/logo/logo.png" alt="Logo Kaizen" />Kaizen</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="dropdown">
                <a href="vetement_all.php" class="dropdown-link">
                    <svg width="32px" height="32px" fill="currentColor" viewBox="0 0 512.02 512.02"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M70.784,270.575c1.664,1.664,3.849,2.5,6.033,2.5s4.369-0.836,6.033-2.5c3.336-3.337,3.336-8.73,0-12.066l-51.2-51.2
      c-8.141-8.141-14.566-14.566-14.566-28.1s6.426-19.959,14.566-28.1l128-128c4.864-4.864,16.051-6.016,19.567-6.033h179.2v153.609
      H196.326h-0.085H42.735c-4.719,0-8.533,3.823-8.533,8.533c0,4.71,3.814,8.533,8.533,8.533h150.025l48.691,48.691
      c1.664,1.664,3.849,2.5,6.033,2.5c2.185,0,4.369-0.836,6.033-2.5c3.337-3.337,3.337-8.73,0-12.066l-36.625-36.625h201.31
      c4.719,0,8.533-3.823,8.533-8.533c0-4.71-3.814-8.533-8.533-8.533h-42.718v-17.075h42.667c4.719,0,8.533-3.823,8.533-8.533
      c0-4.71-3.814-8.533-8.533-8.533h-42.667v-17.067h42.667c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533h-42.667
      V85.342h42.667c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533h-42.667V51.209h42.667
      c4.719,0,8.533-3.823,8.533-8.533c0-4.71-3.814-8.533-8.533-8.533h-42.667V17.075h42.667c4.719,0,8.533-3.823,8.533-8.533
      s-3.814-8.533-8.533-8.533H179.217c-2.108,0-20.907,0.307-31.633,11.034l-128,128c-8.713,8.721-19.567,19.567-19.567,40.166
      s10.854,31.445,19.567,40.166L70.784,270.575z" />
                        <path d="M494.95,411.179v-27.17c0-72.363-56.115-134.912-128.512-150.059c-2.432-16.444-16.503-29.141-33.621-29.141
      s-31.189,12.698-33.621,29.141c-72.397,15.147-128.512,77.696-128.512,150.059c0,4.71,3.814,8.533,8.533,8.533
      c4.719,0,8.533-3.823,8.533-8.533c0-64.794,53.845-122.377,120.218-134.195c0.068-0.009,0.128-0.009,0.196-0.009
      c0.06-0.009,0.102-0.043,0.162-0.043c8.013-1.408,16.179-2.287,24.491-2.287c77.278,0,145.067,63.804,145.067,136.533v34.133
      c0,4.71,3.814,8.533,8.533,8.533c4.71,0,8.533,3.831,8.533,8.533v51.2c0,4.702-3.823,8.533-8.533,8.533h-8.533v-42.667
      c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667H443.75v-42.667c0-4.71-3.814-8.533-8.533-8.533
      s-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667h-17.067
      v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667H341.35v-42.667c0-4.71-3.814-8.533-8.533-8.533
      s-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667
      h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667H238.95v-42.667
      c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533
      s-8.533,3.823-8.533,8.533v42.667h-8.533c-4.71,0-8.533-3.831-8.533-8.533v-51.2c0-4.702,3.823-8.533,8.533-8.533h273.067
      c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533H179.217c-14.114,0-25.6,11.486-25.6,25.6v51.2
      c0,14.114,11.486,25.6,25.6,25.6h307.2c14.114,0,25.6-11.486,25.6-25.6v-51.2C512.017,424.098,504.858,414.72,494.95,411.179z
       M332.817,230.409c-5.086,0-10.12,0.29-15.095,0.751c2.833-5.487,8.499-9.284,15.095-9.284c6.545,0,12.177,3.746,15.019,9.276
      C342.878,230.699,337.877,230.409,332.817,230.409z" />
                        <path d="M128.017,460.809H68.284v-153.6h93.867c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533H8.533
      c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533
      c0,4.71,3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067
      H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533
      s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h119.484
      c4.719,0,8.533-3.823,8.533-8.533S132.736,460.809,128.017,460.809z" />
                    </svg>
                    <?=$translations['menu_cloth']??'Vêtements'?>
                </a>
                <ul class="sub">
                    <li class="sub-dropdown">
                        <span><?=$translations['menu_men']??'Homme'?> <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="homme.php"><?=$translations['menu_men_all']??'Homme - Tout voir'?></a></li>
                            <li><a href="vetement_homme.php"><?=$translations['menu_cloth']??'Vêtements'?></a></li>
                            <li><a
                                    href="sous-vetement-homme.php"><?=$translations['menu_underwear']??'Sous-vêtements'?></a>
                            </li>
                            <li><a href="lunette-homme.php"><?=$translations['menu_glasse']??'Lunettes'?></a></li>
                            <li><a href="gants-homme.php"><?=$translations['menu_glove']??'Gants'?></a></li>
                            <li><a href="chaussure-homme.php"><?=$translations['menu_shove']??'Chaussures'?></a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <span><?=$translations['menu_women']??'Femme'?> <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="femme.php"><?=$translations['menu_women_all']??'Femme - Tout voir'?></a></li>
                            <li><a href="vetement_femme.php"><?=$translations['menu_cloth']??'Vêtements'?></a></li>
                            <li><a
                                    href="sous-vetement-femme.php"><?=$translations['menu_underwear']??'Sous-vêtements'?></a>
                            </li>
                            <li><a href="lunette-femme.php"><?=$translations['menu_glasse']??'Lunettes'?></a></li>
                            <li><a href="gants-femme.php"><?=$translations['menu_glove']??'Gants'?></li>
                            <li><a href="chaussure-femme"><?=$translations['menu_shove']??'Chaussures'?></a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <span><?=$translations['menu_child']??'Enfant'?> <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="enfant.php"><?=$translations['menu_child_all']??'Enfant - Tout voir'?></a></li>
                            <li><a href="vetement_enfant.php"><?=$translations['menu_cloth']??'Vêtements'?></a></li>
                            <li><a
                                    href="sous-vetement-enfant.php"><?=$translations['menu_underwear']??'Sous-vêtements'?></a>
                            </li>
                            <li><a href="lunette-enfant.php"><?=$translations['menu_glasse']??'Lunettes'?></a></li>
                            <li><a href="gants-enfant.php"><?=$translations['menu_glove']??'Gants'?></a></li>
                            <li><a href="chaussure-enfant.php"><?=$translations['menu_shove']??'Chaussures'?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="accessoire.php" class="dropdown-link">
                    <svg viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                        class="menu-svg-accessories">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M26.2409 33.633L31.3639 35.498C33.0209 36.101 34.8379 35.375 35.6459 33.864L36.5919 34.209C35.6189 36.177 33.3389 37.17 31.2169 36.504L31.0169 36.436L24.2609 33.978L24.2519 33.974L24.2429 33.97L7.99988 28.058L8.34188 27.118L26.2409 33.633Z"
                                fill="currentColor"></path>
                            <path
                                d="M26.2409 33.633L31.3639 35.498C33.0209 36.101 34.8379 35.375 35.6459 33.864L36.5919 34.209C35.6189 36.177 33.3389 37.17 31.2169 36.504L31.0169 36.436L24.2609 33.978L24.2519 33.974L24.2429 33.97L7.99988 28.058L8.34188 27.118L26.2409 33.633Z"
                                stroke="currentColor"></path>
                            <path
                                d="M24.8639 32.733L29.2689 26.781C29.6909 26.212 29.6519 25.434 29.2009 24.91L29.1899 24.897L29.1789 24.886L29.0899 24.796L29.0789 24.785L29.0679 24.774L26.3989 22.371C26.2339 22.221 26.1889 21.984 26.2809 21.787L26.3259 21.71L29.0999 17.546L30.2979 18.345V18.356L30.3019 18.388L30.3339 18.634L30.3349 18.647C30.3479 18.726 30.3609 18.801 30.3759 18.867C30.6079 19.873 31.1419 20.663 32.0179 21.196C32.8339 21.691 33.9089 21.941 35.2339 21.99V22.99C32.2709 22.883 30.4319 21.806 29.6609 19.916L29.3049 19.044L28.7819 19.828L27.6299 21.557L27.3899 21.916L27.7109 22.207L29.7369 24.031C30.6519 24.855 30.8249 26.216 30.1689 27.238L30.0689 27.382L25.6179 33.294M20.6019 31.208L23.8249 26.992L24.1149 26.613L23.7499 26.307L20.7489 23.774C20.2659 23.366 19.9949 22.788 19.9649 22.19L21.0829 22.61C21.1299 22.705 21.1889 22.796 21.2599 22.878L21.2729 22.893L21.2869 22.906L21.3659 22.983L21.3799 22.998L21.3939 23.009L25.1239 26.158C25.3089 26.313 25.3529 26.575 25.2389 26.781L25.1899 26.854L21.3149 31.759M17.6749 16.692L18.0579 16.835L18.2739 16.49L19.1509 15.089C19.3119 14.832 19.4899 14.586 19.6849 14.354C21.5839 12.092 24.6969 11.449 27.2719 12.578L28.1049 12.944L27.9679 12.046C27.8489 11.269 27.9909 10.449 28.4269 9.72199C29.4229 8.06499 31.5729 7.52899 33.2299 8.52399C34.8869 9.51999 35.4229 11.669 34.4279 13.326C33.9679 14.09 33.2649 14.615 32.4759 14.863L32.3149 14.914L32.2179 15.052L31.7529 15.709L30.9089 15.147L31.6679 14.013C32.4279 13.939 33.1459 13.517 33.5699 12.811C34.2809 11.628 33.8989 10.093 32.7149 9.38199C31.5319 8.66999 29.9959 9.05299 29.2849 10.237C28.8629 10.938 28.8259 11.763 29.1109 12.466L28.0629 14.21C25.7389 12.381 22.3659 12.717 20.4509 14.998C20.3409 15.129 20.2369 15.264 20.1399 15.404L20.1329 15.414L20.0049 15.61L19.9989 15.619L19.3379 16.677L19.0129 17.194L19.5859 17.41"
                                fill="currentColor"></path>
                            <path
                                d="M24.8639 32.733L29.2689 26.781C29.6909 26.212 29.6519 25.434 29.2009 24.91L29.1899 24.897L29.1789 24.886L29.0899 24.796L29.0789 24.785L29.0679 24.774L26.3989 22.371C26.2339 22.221 26.1889 21.984 26.2809 21.787L26.3259 21.71L29.0999 17.546L30.2979 18.345V18.356L30.3019 18.388L30.3339 18.634L30.3349 18.647C30.3479 18.726 30.3609 18.801 30.3759 18.867C30.6079 19.873 31.1419 20.663 32.0179 21.196C32.8339 21.691 33.9089 21.941 35.2339 21.99V22.99C32.2709 22.883 30.4319 21.806 29.6609 19.916L29.3049 19.044L28.7819 19.828L27.6299 21.557L27.3899 21.916L27.7109 22.207L29.7369 24.031C30.6519 24.855 30.8249 26.216 30.1689 27.238L30.0689 27.382L25.6179 33.294M20.6019 31.208L23.8249 26.992L24.1149 26.613L23.7499 26.307L20.7489 23.774C20.2659 23.366 19.9949 22.788 19.9649 22.19L21.0829 22.61C21.1299 22.705 21.1889 22.796 21.2599 22.878L21.2729 22.893L21.2869 22.906L21.3659 22.983L21.3799 22.998L21.3939 23.009L25.1239 26.158C25.3089 26.313 25.3529 26.575 25.2389 26.781L25.1899 26.854L21.3149 31.759M17.6749 16.692L18.0579 16.835L18.2739 16.49L19.1509 15.089C19.3119 14.832 19.4899 14.586 19.6849 14.354C21.5839 12.092 24.6969 11.449 27.2719 12.578L28.1049 12.944L27.9679 12.046C27.8489 11.269 27.9909 10.449 28.4269 9.72199C29.4229 8.06499 31.5729 7.52899 33.2299 8.52399C34.8869 9.51999 35.4229 11.669 34.4279 13.326C33.9679 14.09 33.2649 14.615 32.4759 14.863L32.3149 14.914L32.2179 15.052L31.7529 15.709L30.9089 15.147L31.6679 14.013C32.4279 13.939 33.1459 13.517 33.5699 12.811C34.2809 11.628 33.8989 10.093 32.7149 9.38199C31.5319 8.66999 29.9959 9.05299 29.2849 10.237C28.8629 10.938 28.8259 11.763 29.1109 12.466L28.0629 14.21C25.7389 12.381 22.3659 12.717 20.4509 14.998C20.3409 15.129 20.2369 15.264 20.1399 15.404L20.1329 15.414L20.0049 15.61L19.9989 15.619L19.3379 16.677L19.0129 17.194L19.5859 17.41"
                                stroke="currentColor"></path>
                            <path d="M8.60785 14.061L24.6138 20.065" stroke="currentColor" stroke-width="2"></path>
                        </g>
                    </svg>
                    <?=$translations['menu_accessory']??'Accessoirs'?></a>
                <ul class="sub">
                    <li class="sub-dropdown">
                        <span><?=$translations['all']??'Voir plus'?> <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="ski.php"><?=$translations['ski']??'Ski Alpin'?></a></li>
                            <li><a href="snow.php"><?=$translations['snowboard']??'Snowboard'?></a></li>
                            <li><a href="luge.php"><?=$translations['sled']??'Luge'?></a></li>
                            <li><a href="raquette.php"><?=$translations['snowshoe']??'Raquettes'?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="tutoriel.html"><svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.8958 5.5L2.5625 9.66667L1.8125 7.66667C1.5625 6.75 2.0625 5.83333 2.89584 5.58333L14.1458 2.25C15.0625 2 15.9792 2.5 16.2292 3.33334L16.8958 5.5Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.22913 4.91669L7.81246 8.16669" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M10.3959 3.33331L12.9792 6.66665" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M2.5625 9.66669H17.5625V16.3334C17.5625 16.7754 17.3869 17.1993 17.0743 17.5119C16.7618 17.8244 16.3379 18 15.8958 18H4.22917C3.78714 18 3.36322 17.8244 3.05066 17.5119C2.73809 17.1993 2.5625 16.7754 2.5625 16.3334V9.66669Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <?=$translations['menu_tutorial']??'Tutoriels'?></a>
            </li>
            <li>
                <a href="contact.html" aria-label="Menu Vêtements">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.8958 18V16.3333C15.8958 15.4493 15.5446 14.6014 14.9195 13.9763C14.2944 13.3512 13.4465 13 12.5625 13H7.56246C6.6784 13 5.83056 13.3512 5.20544 13.9763C4.58032 14.6014 4.22913 15.4493 4.22913 16.3333V18"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M10.0625 9.66667C11.9034 9.66667 13.3958 8.17428 13.3958 6.33333C13.3958 4.49238 11.9034 3 10.0625 3C8.22151 3 6.72913 4.49238 6.72913 6.33333C6.72913 8.17428 8.22151 9.66667 10.0625 9.66667Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Contact</a>
            </li>
            <li>
                <a href="panier.php">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.22921 18.8334C7.68944 18.8334 8.06254 18.4603 8.06254 18C8.06254 17.5398 7.68944 17.1667 7.22921 17.1667C6.76897 17.1667 6.39587 17.5398 6.39587 18C6.39587 18.4603 6.76897 18.8334 7.22921 18.8334Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M16.3958 18.8334C16.8561 18.8334 17.2292 18.4603 17.2292 18C17.2292 17.5398 16.8561 17.1667 16.3958 17.1667C15.9356 17.1667 15.5625 17.5398 15.5625 18C15.5625 18.4603 15.9356 18.8334 16.3958 18.8334Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M2.27087 2.20831H3.93754L6.15421 12.5583C6.23552 12.9374 6.44643 13.2762 6.75063 13.5165C7.05483 13.7568 7.4333 13.8836 7.82087 13.875H15.9709C16.3502 13.8744 16.7179 13.7444 17.0134 13.5065C17.3088 13.2686 17.5143 12.9371 17.5959 12.5666L18.9709 6.37498H4.82921"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <?=$translations['menu_shop']??'Panier'?></a>
            </li>
        </ul>
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

    div class="product-container">
    <div class="product-images">
        <?php if (!empty($product['images'])): ?>
        <?php foreach ($product['images'] as $image): ?>
        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <?php endforeach; ?>
        <?php else: ?>
        <p><?= $translations['empty_cart'] ?></p>
        <?php endif; ?>
    </div>
    <div class="product-info">
        <h1 class="product-brand"><?= htmlspecialchars($product['brand']) ?></h1>
        <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>
        <p>
            <span class="product-price"><?= htmlspecialchars($product['price']) ?>€</span>
            <?php if (!empty($product['old_price'])): ?>
            <span class="product-old-price"><?= htmlspecialchars($product['old_price']) ?>€</span>
            <?php endif; ?>
        </p>
        <div class="product-description">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
        </div>
        <form action="panier.php" method="POST">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
            <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['price']) ?>">
            <div class="color-swatches">
                <?php foreach ($product['colors'] as $color): ?>
                <div class="color-swatch">
                    <input type="radio" id="color-<?= htmlspecialchars($color) ?>-<?= $product['id'] ?>"
                        name="product_color" value="<?= htmlspecialchars($color) ?>" required>
                    <label for="color-<?= htmlspecialchars($color) ?>-<?= $product['id'] ?>"
                        style="background-color: <?= htmlspecialchars($color) ?>;"></label>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="size-selection">
                <label for="size"><?= $translations['size'] ?>:</label><br>
                <select id="size" name="product_size" class="styled-select" required>
                    <option value="" disabled selected><?= $translations['select_size'] ?? 'Select a size' ?></option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            <div class="quantity-selection">
                <label for="quantity"><?= $translations['quantity'] ?? 'Quantity' ?>:</label><br>
                <input type="number" name="quantity" id="quantity" value="1" min="1" required>
            </div>
            <div class="cta">
                <button type="submit" class="btn"><?= $translations['add_to_cart'] ?? 'Add to cart' ?></button>
            </div>
        </form>
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
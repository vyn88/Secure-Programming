<?php 
    $email = htmlspecialchars($_POST["email"]);

    $token = bin2hex(random_bytes(16));

    $hashed_token = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 60);

    $sql = require("../database/database2.php");

    $newsql = "UPDATE users
               SET reset_token_hash = ?, 
               reset_token_expires_at = ?
               WHERE email = ?";

    $stmt = $sql->prepare($newsql);

    $stmt->bind_param("sss", $hashed_token, $expiry, $email);

    $stmt->execute();

    if ($sql->affected_rows){
        $mail = require("configure-smtp.php");

        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);

        $mail->Subject = "Password Reset";
        $mail->Body = <<<END

        Click <a href = "http://127.0.0.1:1234/reset.php?token=$token"> here </a> to reset your password. 
        END;

        try{
            $mail->send();
        } catch (Exception $e){
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    else {
        echo("Email not found!");
        die;
    }

    echo "Message sent, please check your inbox.";
?>
<?php

use TOOL\HTTP\REQ;
use TOOL\Network\Network;

if (REQ::$query->message) {
    $out = Network::curl("https://api.openai.com/v1/completions", json_encode([
        "model" => "text-davinci-003",
        "prompt" => REQ::$query->conv . "\n Human" . REQ::$query->message . "\n AI: ",
        "temperature" => 0.9,
        "max_tokens" => 150,
        "top_p" => 1,
        "frequency_penalty" => 0,
        "presence_penalty" => 0.6,
        "stop" => [
            "Human:",
            "AI:"
        ]
    ]), [
        'Authorization: Bearer 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',
        'Content-Type: application/json'
    ]);

    $out = json_decode($out);

    $reply = trim($out->choices[0]->text);

    $conv = (REQ::$query->conv ?? '') . "\n" . (REQ::$query->message ? "Human: " . REQ::$query->message : '') . "\n" . ($reply ? "AI: " . $reply : '');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            direction: rtl;
        }

        input {
            width: 500px;
            font-size: 20px;
        }

        textarea {
            width: 90vw;
            height: 300px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <input type="text" placeholder="Your text..." name="message" autofocus />
        <br />
        <br />
        <textarea name="conv" id="conv"><?= $conv ? $conv : '' ?></textarea>
    </form>
    <br />
    <h3><?= REQ::$query->message ? $reply : ''; ?></h3>

    <script>
        var textarea = document.getElementById('conv');
        textarea.scrollTop = textarea.scrollHeight;
    </script>
</body>

</html>
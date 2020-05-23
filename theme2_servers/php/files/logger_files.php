<meta charset="utf-8">
<h1>Logs</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $r = htmlentities($_POST['message']) ?? 'Empty message';

    $file = fopen('log.txt', 'at');
    fwrite($file, $r);
    fwrite($file, "\n");
    fclose($file);
    echo '<h3>The message has been added. Thank you!</h3>';
}
echo '<h2>The form</h2>';
echo "<form method=\"post\" action=\"/logger_files.php\">";
echo <<<_END
    <div>
        <label>Message</label>
        <input id="message" name="message" type="text" required>
        <button type="submit">Send the message</button>
    </div>
_END;
echo '</form>';
echo "<h2>List of messages...</h2>\n";
require_once('list.php');

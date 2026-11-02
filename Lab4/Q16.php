<?php

if (isset($_POST['theme'])) {

    $theme = $_POST['theme'];

    if (in_array($theme, ['light', 'dark'], true)) {

        setcookie(
            "theme",
            $theme,
            [
                'expires' => time() + 86400,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        header("Location: cookie.php");
        exit;
    }
}

$theme = $_COOKIE['theme'] ?? 'light';

echo "Selected Theme: " .
     htmlspecialchars($theme);

?>

<form method="POST">

    <select name="theme">
        <option value="light">Light</option>
        <option value="dark">Dark</option>
    </select>

    <button type="submit">Save Preference</button>

</form>

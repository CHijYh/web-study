<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма регистрации</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 20px; }
        .form-container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .field { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="tel"], input[type="email"], input[type="date"], textarea, select {
            width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;
        }
        .error { color: red; background: #ffdada; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .success { color: green; background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Заполните профиль</h2>

    <?php
    session_start();
    if (!empty($_SESSION['messages'])) {
        $status_class = $_SESSION['status'] == 'error' ? 'error' : 'success';
        echo '<div class="' . $status_class . '">' . implode('<br>', $_SESSION['messages']) . '</div>';
        unset($_SESSION['messages']);
        unset($_SESSION['status']);
    }
    ?>

    <form action="form.php" method="POST">
        <div class="field">
            <label>ФИО:</label>
            <input type="text" name="fio" required>
        </div>
        <div class="field">
            <label>Телефон:</label>
            <input type="tel" name="phone" required>
        </div>
        <div class="field">
            <label>E-mail:</label>
            <input type="email" name="email" required>
        </div>
        <div class="field">
            <label>Дата рождения:</label>
            <input type="date" name="birthday" required>
        </div>
        <div class="field">
            <label>Пол:</label>
            <input type="radio" name="gender" value="male" checked> Мужской
            <input type="radio" name="gender" value="female"> Женский
        </div>
        <div class="field">
            <label>Любимые языки программирования:</label>
            <select name="languages[]" multiple size="5" required>
                <option value="Pascal">Pascal</option>
                <option value="C">C</option>
                <option value="C++">C++</option>
                <option value="JavaScript">JavaScript</option>
                <option value="PHP">PHP</option>
                <option value="Python">Python</option>
                <option value="Java">Java</option>
                <option value="Go">Go</option>
            </select>
        </div>
        <div class="field">
            <label>Биография:</label>
            <textarea name="bio" rows="3"></textarea>
        </div>
        <div class="field">
            <input type="checkbox" name="contract" value="y" required> С контрактом ознакомлен(а)
        </div>
        <button type="submit" style="width:100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Сохранить</button>
    </form>
</div>

</body>
</html>

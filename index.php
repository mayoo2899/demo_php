<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #000;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        main {
            background: #111;
            padding: 40px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: #fff;
            margin-bottom: 5px;
            font-size: 14px;
        }

        input {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 6px;
            background: #1a1a1a;
            color: #fff;
            outline: none;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: #00ffcc;
            box-shadow: 0 0 8px #00ffcc;
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #00ffcc;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: #00ccaa;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <main>
        <form action="includes/formhandler.php" method="post">
            <label for="name">Name</label>
            <input required type="text" id="name" name="name">

            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <button type="submit">Submit</button>
        </form>
    </main>
</body>
</html>
<?php
// check ID
if (!isset($serviceGroupId)) {
    die("Service group ID not set.");
}

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "serviceco";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// fetch service group details
$sql = "SELECT * FROM service_groups WHERE id = $serviceGroupId";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $groupName = $row['name'];
    $groupEmail = $row['email'];
    $groupColor = $row['color'];
    $groupLogo = $row['logo'];
    $groupUrl = $row['url'];
    $groupDescription = $row['description'];
} else {
    echo "Service group not found.";
    exit;
}

// fetch products for this service group
$product_sql = "SELECT * FROM products WHERE service_group_id = $serviceGroupId";
$product_result = mysqli_query($conn, $product_sql);

// close connection after queries
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../../logo.png">
        <title><?php echo $groupName; ?></title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: <?php echo $groupColor; ?>;
                padding: 1em 0;
                text-align: center;
            }

            header img {
                width: 100px;
                height: auto;
                transition: transform 0.3s ease;
            }

            header a:hover img {
                transform: scale(1.1);
            }

            footer {
                text-align: center;
            }

            main {
                padding: 2em;
                max-width: 1200px;
                margin: 0 auto;
            }

            h1, h2 {
                color: #000;
            }

            h2 {
                border-bottom: 2px solid <?php echo $groupColor; ?>;
                padding-bottom: 0.5em;
            }

            #goals, #products {
                margin-bottom: 2em;
            }

            .product-wall {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 20px;
                margin-top: 2em;
            }

            .product-wall a {
                display: block;
                text-align: center;
                text-decoration: none;
            }

            .product-wall img {
                max-width: 100%;
                height: auto;
                transition: transform 0.3s ease;
            }

            .product-wall a:hover img {
                transform: scale(1.1);
            }

            .product-name {
                margin-top: 0.5em;
                color: #333;
                font-size: 1em;
                font-weight: bold;
            }

            .home-button {
                display: inline-block;
                margin-top: 1em;
                padding: 10px 20px;
                background-color: <?php echo $groupColor; ?>;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }

            .home-button:hover {
                background-color: #333;
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>
        <header>
            <a href="<?php echo $groupUrl ?>"><img src="<?php echo $groupLogo; ?>" alt="<?php echo $groupName; ?> Logo"></a>
            <h1>Welcome to <?php echo $groupName; ?></h1>
            <p><?php echo $groupEmail ?></p>
            <a href="http://localhost/ServiceCo/index.php" class="home-button">Back To ServiceCo</a>
        </header>
        <main>
            <section id="goals">
                <h2>Our Goals</h2>
                <p><?php echo $groupDescription; ?></p>
            </section>
            <section id="products">
                <h2>Our Products</h2>
                <div class="product-wall">
                    <?php 
                    if (mysqli_num_rows($product_result) > 0) {
                        while ($product = mysqli_fetch_assoc($product_result)) {
                            echo '<a href="#">';
                            echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '">';
                            echo '<p class="product-name">' . $product['name'] . '</p>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>No products available for this service group.</p>';
                    }
                    ?>
                </div>
            </section>
        </main>
        <footer>
            <p>2024 <?php echo $groupName; ?></p>
        </footer>
    </body>
</html>
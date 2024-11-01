<?php

require '../config/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-product'])) {


    $product_type = $conn->real_escape_string(trim($_POST['product_type']));
    $quantity = $conn->real_escape_string(trim($_POST['quantity']));
    $price = $conn->real_escape_string(trim($_POST['price']));
    $created_at = date('Y-m-d H:i:s');
    $archive = "no";

    $sql = "INSERT INTO products (product_type, quantity, price, date_added, archive) VALUES (?, ?, ?, ?, ?)";


    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssiss", $product_type, $quantity, $price, $created_at, $archive);


        if ($stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'New Product add successfully',
                });
            </script>
            ";
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['purchase-btn'])) {
    $purchase_id = $_POST['purchase_id'];
    $quantity = $_POST['quantity'];
    $availableQuantity = $_POST['availableQuantity'];

    if (empty($purchase_id) || empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid purchase data.',
            });
        </script>
        ";
        header("Location: ../pages/admin.php");
        exit();
    }

    $query = "SELECT product_type, price, quantity FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        if ($quantity <= $product['quantity']) {
            $new_available_quantity = $product['quantity'] - $quantity;

            $update_query = "UPDATE products SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $new_available_quantity, $purchase_id);

            if ($update_stmt->execute()) {
                $total_amount = $product['price'] * $quantity;
                $transaction_date = date('Y-m-d H:i:s');

                $insert_query = "INSERT INTO transaction_history ( product_type, quantity, transaction_date, price, total_amount) VALUES ( ?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("sisdd", $product['product_type'], $quantity, $transaction_date, $product['price'], $total_amount);

                if ($insert_stmt->execute()) {
                    $_SESSION['alert'] = "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Purchase successful! Quantity updated and transaction recorded.',
                        });
                    </script>
                    ";
                    if ($new_available_quantity == 0) {
                        $archive_query = "UPDATE products SET archive = 'yes' WHERE id = ?";
                        $archive_stmt = $conn->prepare($archive_query);
                        $archive_stmt->bind_param("i", $purchase_id);
                        if ($archive_stmt->execute()) {
                            $_SESSION['alert'] = "
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Product sold out and archived.',
                                });
                            </script>
                            ";
                        } else {
                            $_SESSION['alert'] = "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error in archiving the product after purchase.',
                                });
                            </script>
                            ";
                        }
                    }
                } else {
                    $_SESSION['alert'] = "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error in recording the transaction history.',
                        });
                    </script>
                    ";
                }
            } else {
                $_SESSION['alert'] = "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error in updating the product quantity.',
                    });
                </script>
                ";
            }
        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient quantity available.',
                });
            </script>
            ";
        }
    } else {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Product not found.',
            });
        </script>
        ";
    }

    header("Location: ../pages/admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit-product'])) {
    $productId = $_POST['product_id'];
    $productType = $_POST['product_type'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];


    $stmt = $conn->prepare("UPDATE products SET product_type = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sidi", $productType, $quantity, $price, $productId);


    if ($stmt->execute()) {

        $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Updated Successfully.',
                });
            </script>
            ";
    } else {

        $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'connection error',
                });
            </script>
            ";
    }

    header("Location: ../pages/admin.php");
    exit();
}


?>
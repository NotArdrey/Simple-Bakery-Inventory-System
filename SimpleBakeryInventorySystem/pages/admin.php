<?php
require '../config/dbconn.php';
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakeshop</title>
    <link rel="stylesheet" href="../style/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0u1+Ko2A3WSXU8B8v7uYF6WfhMTzAC5ZfZx5ddtKkM4KaNmi5a68F40Vz5Dui1Li" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="../js/script.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        .static-alert-container {
            position: absolute;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <hr>
        <ul>
            <li><a href="#" class="nav-link" data-target="batches"><i class="fas fa-boxes" style="margin-right: 8px;"></i>Show Batches</a></li>
            <li><a href="#" class="nav-link" data-target="transaction-history"><i class="fas fa-history" style="margin-right: 8px;"></i>Transaction History</a></li>
            <li><a href="../function/logout.php" id="nav-link"><i class="fas fa-door-open" style="margin-right: 8px;"></i>Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <!--Batch List first page-->
        <div id="batches" class="content-section" style="display: block;">
            <div class="container mt-5">
                <h2>Products List</h2>
                <div class="d-flex justify-content-between mb-3">
                    <div>
         
                    </div>
                    <div>
                        <button class="btn btn-info" data-toggle="modal" data-target="#addModal">Add New</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered mx-auto medium">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Type</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="reservationTable">

                    <?php
                        $sql = "SELECT id, product_type, quantity, price, date_added 
                                FROM products 
                                WHERE CAST(quantity AS UNSIGNED) > 0 AND archive = 'no' 
                                ORDER BY product_type, date_added ASC";
                        $result = $conn->query($sql);
                        $latestProducts = [];

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $productType = $row['product_type'];


                                if (!isset($latestProducts[$productType])) {
                                    $latestProducts[$productType] = $row;
                                }
                            }

                            foreach ($latestProducts as $product) {
                                echo "<tr>";
                                echo "<td>" . $product['product_type'] . "</td>";
                                echo "<td>" . $product['quantity'] . "</td>";
                                echo "<td>" . $product['price'] . "</td>";
                                echo "<td>" . $product['date_added'] . "</td>";
                                echo "<td>
                                                <a href='#' 
                                                data-toggle='modal' 
                                                data-target='#editModal' 
                                                data-id='" . $product['id'] . "' 
                                                data-producttype='" . $product['product_type'] . "' 
                                                data-quantity='" . $product['quantity'] . "' 
                                                data-price='" . $product['price'] . "' 
                                                data-dateadded='" . $product['date_added'] . "' 
                                                class='btn btn-warning btn-sm'>Edit</a>";

                                echo " <button class='btn btn-info btn-sm' data-toggle='modal' data-target='#purchaseModal' data-id='" . $product['id'] . "'>Purchase</button>";

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>




        <!-- Transaction history-->
        <div id="transaction-history" class="content-section" style="display: none;">
        <div class="container mt-5">
        <h2>Transaction History</h2>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
            <div>
                <button class="btn btn-secondary" onclick="generatePDF()">Generate PDF</button>
                <select id="sortOptions" class="form-select" onchange="sortTable()">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="date-asc">Date (Oldest first)</option>
                    <option value="date-desc">Date (Latest first)</option>
                </select>
            </div>
        </div>
        <table class="table table-striped table-bordered mx-auto medium">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Product Type</th>
                    <th>Quantity</th>
                    <th>Transaction Date</th>
                    <th>Price</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody id="ReservationTable">
                <?php
                    $sql = "SELECT id, product_type, quantity, transaction_date, price, total_amount
                            FROM transaction_history";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $counter = 1; 
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . $row['product_type'] . "</td>";  
                            echo "<td>" . $row['quantity'] . "</td>";       
                            echo "<td>" . $row['transaction_date'] . "</td>"; 
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['total_amount'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>"; 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

















    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" method="POST" action="../function/admin.php">
                        <input type="hidden" id="editProductId" name="product_id">

                        <div class="mb-3">
                            <label for="editProductType" class="form-label">Product Type</label>
                            <input type="text" class="form-control" id="editProductType" name="product_type" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" name="price" required step="0.01">
                        </div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-product">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" method="POST" action="../function/admin.php">


                        <div class="mb-3">
                            <label for="productType" class="form-label">Product Type</label>
                            <select class="form-control" id="productType" name="product_type" required>
                                <option value="" disabled selected>Select product type</option>
                                <option value="Cookies">Cookies</option>
                                <option value="Cake">Cake</option>
                                <option value="Bread">Bread</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>


                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required step="0.01">
                        </div>


                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add-product">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Purchase Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action='../function/admin.php' method='POST' id="purchaseForm">
                    <div class="modal-body">
                        <input type="hidden" id="purchase_id" name="purchase_id">

                        <p>Are you sure you want to purchase this item?</p>
                        <p><strong>Product Type:</strong> <span id="modalProductType" name="ProductType"></span></p>
                        <p><strong>Available Quantity:</strong> <span id="availableQuantity" name = "availableQuantity"></span></p>


                        <p><strong>Quantity:</strong>
                            <input type="number" name="quantity" id="modalQuantityInput" min="1" max="" value="1" required>
                        </p>


                        <p><strong>Price per Item:</strong> <span id="modalPrice" name="price"></span></p>
                        <p><strong>Total Price:</strong> <span id="modalTotalPrice"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="purchase-btn">Confirm Purchase</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $('#purchaseModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('id');
        var productType = button.closest('tr').find('td:nth-child(1)').text().trim();
        var availableQty = parseInt(button.closest('tr').find('td:nth-child(2)').text().trim());
        var price = parseFloat(button.closest('tr').find('td:nth-child(3)').text().trim());
        var modal = $(this);

        modal.find('#purchase_id').val(productId);
        modal.find('#modalProductType').text(productType);
        modal.find('#availableQuantity').text(availableQty);
        modal.find('#modalPrice').text(price.toFixed(2));

        modal.find('#modalQuantityInput').attr('max', availableQty);
        modal.find('#modalQuantityInput').val(1);

        updateTotalPrice(price, 1);

        modal.find('#modalQuantityInput').on('input change', function() {
            var quantity = parseInt($(this).val());

            if (quantity > availableQty) {
                swal({
                    title: "Quantity Limit Exceeded",
                    text: "Quantity cannot exceed available stock.",
                    icon: "warning",
                    buttons: {
                        cancel: "OK",
                    },
                    dangerMode: true,
                });
                $(this).val(availableQty);
                quantity = availableQty;
            } else if (quantity < 1) {
                $(this).val(1);
                quantity = 1;
            }

            updateTotalPrice(price, quantity);
        });
    });

    function updateTotalPrice(price, quantity) {
        var totalPrice = price * quantity;
        $('#modalTotalPrice').text(totalPrice.toFixed(2));
    }



    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('id');
        var productType = button.closest('tr').find('td:nth-child(1)').text().trim();
        var quantity = parseInt(button.data('quantity'));
        var price = parseFloat(button.data('price'));

        var modal = $(this);

        modal.find('#editProductId').val(productId);
        modal.find('#editProductType').val(productType);
        modal.find('#editQuantity').val(quantity);
        modal.find('#editPrice').val(price.toFixed(2));
    });

    document.getElementById('searchInput').addEventListener('keyup', function () {
    const searchValue = this.value.toLowerCase().trim(); 
    const rows = document.querySelectorAll('#ReservationTable tr'); 

    rows.forEach(row => {
        const productType = row.querySelector('td:nth-child(2)'); 
        if (productType) { 
            const text = productType.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none'; 
        }
    });
});


function sortTable() {
    const tableBody = document.getElementById("ReservationTable");
    const rows = Array.from(tableBody.getElementsByTagName("tr"));
    const sortOption = document.getElementById("sortOptions").value;

    rows.sort((a, b) => {
        const aCells = a.getElementsByTagName("td");
        const bCells = b.getElementsByTagName("td");

        let comparison = 0;

        switch (sortOption) {
            case "name-asc":
                comparison = aCells[1].innerText.localeCompare(bCells[1].innerText);
                break;
            case "name-desc":
                comparison = bCells[1].innerText.localeCompare(aCells[1].innerText);
                break;
            case "date-asc":
                comparison = new Date(aCells[3].innerText) - new Date(bCells[3].innerText);
                break;
            case "date-desc":
                comparison = new Date(bCells[3].innerText) - new Date(aCells[3].innerText);
                break;
        }

        return comparison;
    });


    while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }

    rows.forEach((row, index) => {
        row.cells[0].innerText = index + 1; 
        tableBody.appendChild(row);
    });
}





    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.text("Transaction History Report", 14, 20);


        const columns = ["#", "Product Type", "Quantity", "Transaction Date", "Price", "Total Amount"];


        const tableData = [];
        const rows = document.querySelectorAll("#ReservationTable tr");

        rows.forEach((row, index) => {
            const cells = row.querySelectorAll("td");
            if (cells.length > 0) {
                const rowData = [
                    index + 1,
                    cells[1].textContent,
                    cells[2].textContent,
                    cells[3].textContent,
                    cells[4].textContent,
                    cells[5].textContent
                ];
                tableData.push(rowData);
            }
        });

        const totalAmount = tableData.reduce((acc, row) => acc + parseFloat(row[5]), 0);

   
        doc.autoTable({
            head: [columns],
            body: tableData,
            startY: 30, 
            theme: 'plain', 
            styles: { 
                fontSize: 10, 
                textColor: [0, 0, 0], 
                lineColor: [0, 0, 0], 
                lineWidth: 0.1 
            },
            headStyles: { 
                fillColor: [255, 255, 255], 
                textColor: [0, 0, 0], 
                fontStyle: 'bold' 
            },
            alternateRowStyles: {
                fillColor: [255, 255, 255], 
            },
            margin: { top: 30 }
        });

        doc.text(`Total Amount: ${totalAmount.toFixed(2)} PHP`, 14, doc.lastAutoTable.finalY + 10); 


        doc.save("transaction_history_report.pdf");
    }
</script>

<?php
if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
}
?>
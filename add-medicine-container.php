<?php
    include('medicine-check.php');
?>
    <div>
            <form id="sign-up" method="post" style="font-size: 100%;">
                    <div class="col">
                        <div class="row">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="row">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="row">
                            <label for="unitsAvailable">Units Available</label>
                            <input type="number" class="form-control" id="unitsAvailable" name="unitsAvailable" required>
                        </div>
                        <div class="row">
                            <label for="unitsSold">Units Sold</label>
                            <input type="number" class="form-control" id="unitsSold" name="unitsSold" required>
                        </div>
                        <div class="row">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-success" type="submit" id="submit-medicine">Add</button>
                    <button class="btn btn-danger" type="button" id="cancel-medicine">Cancel</button>
                    
            </form>
        </div>
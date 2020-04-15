<?php
    include('signup-check.php');
?>
    <div>
            <form id="sign-up" method="post" style="font-size: 100%;">
                
                    <div class="row">
                        <div class="col">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="col">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="inputGroupPrepend2"  name="username" required>
                        </div>
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col">
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" maxlength="14" data-fv-numeric="true" data-fv-numeric-message="Please enter valid phone numbers" data-fv-phone-country11="IN" data-fv-notempty-message="This field cannot be left blank." class="form-control" name="mobile" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="role">Role</label>
                            <select name="role" id="role" required>
                                <option value="">Select a role</option>
                                <option value="admin">Admin</option>
                                <option value="pharmacist">Pharmacist</option>
                                <option value="cashier">Cashier</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-success" type="submit" id="submit-user">Add</button>
                    <button class="btn btn-danger" type="button" id="cancel-user">Cancel</button>
            </form>
        </div>
<?php include "templates/include/header.php" ?>
            <a class="col-md-2 siteAdminLink" href="admin.php">Site Admin</a>
        </div>

        <form action="admin.php?action=login" method="post">
         	<input type="hidden" name="login" value="true" />
            <fieldset class="form-group">
                <div class="row">
                    <div class="col-md-1">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="username" id="username" placeholder="Your admin username" required autofocus />
                    </div>
                </div>
            </fieldset>

             <fieldset class="form-group">
                <div class="row">
                    <div class="col-md-1">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-md-2">
                        <input type="password" name="password" id="password" placeholder="Your admin password" required />
                    </div>
                </div>
            </fieldset>

            <div class="buttons pull-left">
                <input type="submit" name="login" value="Login" />
            </div>
        </form>
<?php include "templates/include/footer.php" ?>
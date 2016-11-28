<?php include "templates/include/header.php" ?>
    <script>
        function closeKeepAlive() {
            if (/AppleWebkit|MSIE/.test(navigator.userAgent)) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "/ping/close", false);
                xhr.send();
            }
        }
    </script>
            <a class="col-md-2 siteAdminLink" href="admin.php">Site Admin</a>
        </div>

        <div id="adminHeader">
            <h2 class="shop">Emshop</h2>
            <p class="logout">You are logged in as 
                <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. 
                <a class="logoutLink" href="admin.php?action=logout">Log out</a>
            </p>
        </div>

        <h2><?php echo $results['pageTitle'] ?></h2>
  
        <form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data" onsubmit="closeKeepAlive()">
            <input type="hidden" name="goodId" value="<?php echo $results['good']->id ?>" />
            <input type="hidden" name="brandId" value="<?php echo $_SESSION['brandid'] ?>" />

            <?php if (isset($results['errorMessage'])) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
            <?php } ?>

            <hr>
            <h3>Product Details</h3>
            <br>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="title">Title</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="title" id="title" placeholder="Name of the product" required autofocus maxlength="255" value="<?php echo htmlspecialchars($results['good']->title) ?>" />
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="description">Description</label>
                </div>
                <div class="col-md-6">
                    <textarea name="description" id="description" placeholder="Brief description of the product" maxlength="1000"><?php echo htmlspecialchars($results['good']->description) ?></textarea>
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="marketprice">Market Price</label>
                </div>
                <div class="col-md-2">
                    <input type="number" name="marketprice" id="marketprice" placeholder="0" required max="1000000" value="<?php echo $results['good']->marketprice ?>">
                </div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="salesprice">Sales Price</label>
                </div>
                <div class="col-md-2">
                    <input type="number" name="salesprice" id="salesprice" placeholder="0" required max="1000000" value="<?php echo $results['good']->salesprice ?>">
                </div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="stockquantity">Stock Quantity</label>
                </div>
                <div class="col-md-2">
                    <input type="number" name="housenum" id="housenum" placeholder="0" required max="1000000" value="<?php echo $results['good']->housenum ?>">
                </div>
            </fieldset>
        
            <fieldset class="form-group">
            <?php if ($results['good'] && $imagePath = $results['good']->getImagePath()) { ?>
                <div class="row">
                    <div class="col-md-3">
                        <label>Current Try-on Image</label>
                    </div>
                    <div class="col-md-2">
                        <img id="goodImage" src="<?php echo $imagePath ?>" alt="Good Image" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-3 deletebox">
                        <input type="checkbox" name="deleteImage" id="deleteImage" value="yes" />
                        <label for="deleteImage">Delete Original Image</label>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-3">
                    <label for="image">New Image</label>
                </div>
                <div class="col-md-2">
                    <input type="file" name="image" id="image" placeholder="Choose an image to upload" maxlength="255" />
                </div>
            </div>
            </fieldset>

            <hr>

            <!--fields for try-on-->

            <h3>Product Try-on Details</h3>
            <br>

            <fieldset class="form-group">
            <?php if ($results['good'] && $tryonImagePath = $results['good']->getTryonImagePath()) { ?>
                <div class="row">
                    <div class="col-md-3">
                        <label>Current Image</label>
                    </div>
                    <div class="col-md-2">
                        <img id="goodTryonImage" src="<?php echo $tryonImagePath ?>" alt="Good Tryon Image" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-3 deletebox">
                        <input type="checkbox" name="deleteTryonImage" id="deleteTryonImage" value="yes" />
                        <label for="deleteTryonImage">Delete Original Try-on Image</label>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-3">
                    <label for="tryon_image">New Try-on Image</label>
                </div>
                <div class="col-md-2">
                    <input type="file" name="tryon_image" id="tryon_image" placeholder="Choose an image to upload" maxlength="255" />
                </div>
            </div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="gender">Gender</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" name="gender" id="female" value="female" <?php if( isset($results['good']->gender) && $results['good']->gender == 'female' ){ echo 'checked="checked"'; } elseif(!isset($results['good']->gender)){ echo 'checked="checked"'; } ?>  /> Female
                    <input type="radio" name="gender" id="male" value="male" <?php if( isset($results['good']->gender) && $results['good']->gender == 'male' ){ echo 'checked="checked"'; } ?> /> Male
                    <input type="radio" name="gender" id="other" value="other" <?php if( isset($results['good']->gender) && $results['good']->gender == 'other' ){ echo 'checked="checked"'; } ?> /> Other
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="3dflag">3D Model</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" name="modelflag" id="no" value="0" <?php if( isset($results['good']->modelflag) && $results['good']->modelflag == 0 ){ echo 'checked="checked"'; } elseif(!isset($results['good']->modelflag)){ echo 'checked="checked"'; } ?>  /> No
                    <input type="radio" name="modelflag" id="yes" value="1" <?php if( isset($results['good']->modelflag) && $results['good']->modelflag == 1 ){ echo 'checked="checked"'; } ?> /> Yes
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="type">Type</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="radio" name="rtype" id="face" value="face" <?php if( isset($results['good']->rtype) && $results['good']->rtype == 'face' ){ echo 'checked="checked"'; } elseif(!isset($results['good']->rtype)){ echo 'checked="checked"'; } ?>  /> Face
                        <input type="radio" name="rtype" id="hand" value="hand" <?php if( isset($results['good']->rtype) && $results['good']->rtype == 'hand' ){ echo 'checked="checked"'; } ?> /> Hand
                        <input type="radio" name="rtype" id="body" value="body" <?php if( isset($results['good']->rtype) && $results['good']->rtype == 'body' ){ echo 'checked="checked"'; } ?> /> Body
                        <input type="radio" name="rtype" id="other" value="other" <?php if( isset($results['good']->rtype) && $results['good']->rtype == 'other' ){ echo 'checked="checked"'; } ?> /> Other
                    </div>

                    <div class="col-md-6">
                        <input type="radio" name="type" id="earring" value="earring" <?php if( isset($results['good']->type) && $results['good']->type == 'earring' ){ echo 'checked="checked"'; } elseif(!isset($results['good']->type)){ echo 'checked="checked"'; } ?>  /> Earring
                        <input type="radio" name="type" id="glasses" value="glasses" <?php if( isset($results['good']->type) && $results['good']->type == 'glasses' ){ echo 'checked="checked"'; } ?> /> Glasses
                        <input type="radio" name="type" id="hat" value="hat" <?php if( isset($results['good']->type) && $results['good']->type == 'hat' ){ echo 'checked="checked"'; } ?> /> Hat
                        <input type="radio" name="type" id="necklace" value="necklace" <?php if( isset($results['good']->type) && $results['good']->type == 'necklace' ){ echo 'checked="checked"'; } ?> /> Necklace
                        <input type="radio" name="type" id="scarf" value="scarf" <?php if( isset($results['good']->type) && $results['good']->type == 'scarf' ){ echo 'checked="checked"'; } ?> /> Scarf
                        <input type="radio" name="type" id="tie" value="tie" <?php if( isset($results['good']->type) && $results['good']->type == 'tie' ){ echo 'checked="checked"'; } ?> /> Tie
                        <input type="radio" name="type" id="bracelet" value="bracelet" <?php if( isset($results['good']->type) && $results['good']->type == 'bracelet' ){ echo 'checked="checked"'; } ?> /> Bracelet
                        <input type="radio" name="type" id="ring" value="ring" <?php if( isset($results['good']->type) && $results['good']->type == 'ring' ){ echo 'checked="checked"'; } ?> /> Ring
                        <input type="radio" name="type" id="watch" value="watch" <?php if( isset($results['good']->type) && $results['good']->type == 'watch' ){ echo 'checked="checked"'; } ?> /> Watch
                    </div>
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="size">Physical Size(in mm)</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="size" id="size" placeholder="Size of the product" required autofocus maxlength="11" value="<?php echo htmlspecialchars($results['good']->size) ?>" />
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="center_x">Center_x</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="center_x" id="center_x" required autofocus maxlength="30" value="<?php echo htmlspecialchars($results['good']->center_x) ?>" />
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">
                <div class="col-md-3">
                    <label for="center_y">Center_y</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="center_y" id="center_y" required autofocus maxlength="30" value="<?php echo htmlspecialchars($results['good']->center_y) ?>" />
                </div>
                <div class="col-md-3"></div>
            </fieldset>

            <fieldset class="form-group">

            <hr>
            <!--fields for try-on-->

            <div class="buttons">
                <input type="submit" name="saveChanges" value="Save Changes" />
                <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>
        </form>
    </div>
    <?php if ($results['good']->id) { ?>
    <p>
        <a href="admin.php?action=deleteGood&amp;goodId=<?php echo $results['good']->id ?>" onclick="return confirm('Delete This Good?')">Delete This Product</a>
    </p>
    <?php } ?>           
<?php include "templates/include/footer.php" ?>
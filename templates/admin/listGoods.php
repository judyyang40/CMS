<?php include "templates/include/header.php" ?>
            <a class="col-md-2 siteAdminLink" href="admin.php">Site Admin</a>
        </div>

        <div id="adminHeader">
    	    <h2 class="shop">Emshop</h2>
            <p><a class="addGoodsLink" href="admin.php?action=newGood">Add a New Product</a></p>
    	    <p class="logout">You are logged in as 
                <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. 
                <a class="logoutLink" href="admin.php?action=logout">Log out</a>
            </p>
        </div>

        <h2>Your Products</h2>

        <?php if (isset($results['errorMessage'])) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <?php if (isset($results['statusMessage'])) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
        <?php } ?>

        <table cellpadding="0" cellspacing="0" border="0" class="display" id="table" class="table">
            <thead>
                <tr>
                    <th>Updated</th>
                    <th>Product Name</th>
                    <th>Thumbnail</th>
                    <th>Description</th>    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Updated</th>
                    <th>Product Name</th>
                    <th>Thumbnail</th>
                    <th>Description</th>    
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($results['goods'] as $good) { ?>
                <tr onclick="location='admin.php?action=editGood&amp;goodId=<?php echo $good->id ?>'">
                    <td><span class="postDate"><?php echo date('m/d/Y', $good->posttime) ?></span></td>
                    <td><?php echo $good->title ?></td>
                    <td>
                    <?php if ($imagePath = $good->getImagePath(IMG_TYPE_THUMB)) { ?>
                        <img class="goodImageThumb" src="<?php echo $imagePath ?>" alt="Good Thumbnail" />
                    <?php } ?>
                    </td>
                    <td><p class="description"><?php echo htmlspecialchars($good->description) ?></p></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <p><?php echo $results['totalRows'] ?> good<?php echo ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>
<?php include "templates/include/footer.php" ?>
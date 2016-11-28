<?php include "templates/include/header.php" ?>
                <a class="col-md-2 siteAdminLink" href="admin.php">Site Admin</a>
            </div>
            <h1><?php echo htmlspecialchars($results['good']->title) ?></h1>
            <?php if ( $imagePath = $results['good']->getImagePath() ) { ?>
            <img id="goodImageFullsize" src="<?php echo $imagePath?>" alt="Good Image" />
            <?php } ?>
            <div><?php echo htmlspecialchars($results['good']->description) ?></div>
            <p class="posttime">Published on <?php echo date('m/d/Y', $results['good']->posttime) ?></p>
        </div>
        <p><a href="./">Return to Homepage</a></p>
<?php include "templates/include/footer.php" ?>
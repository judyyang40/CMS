<?php include "templates/include/header.php" ?>
            <a class="col-md-2 goodslistLink" href="./?action=goodslist">Product list</a>
            <a class="col-md-2 siteAdminLink" href="admin.php">Site Admin</a>
        </div>
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
                <tr>
                    <td><span class="postDate"><?php echo date('m/d/Y', $good->posttime) ?></span></td>
                    <td><a href=".?action=viewGood&amp;goodId=<?php echo $good->id?>"><?php echo htmlspecialchars($good->title) ?></a></td>
                    <td>
                    <?php if ($imagePath = $good->getImagePath(IMG_TYPE_THUMB)) { ?>
                        <a href=".?action=viewGood&amp;goodId=<?php echo $good->id ?>"><img class="goodImageThumb" src="<?php echo $imagePath?>" alt="Good Thumbnail" /></a>
                    <?php } ?>
                    </td>
                    <td><p class="description"><?php echo htmlspecialchars($good->description) ?></p></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<?php include "templates/include/footer.php" ?>

<?php

/**
 * Class to handle goods
 */

class Good {
	// Properties
    
    /**
    * @var int The good ID from the database
    */
    public $id = null;

    /**
    * @var int The brand ID from the database
    */
    public $brandid = null;

    /**
    * @var int When the good is to be / was first added
    */
    public $posttime = null;

    /**
    * @var string Full title of the good
    */
    public $title = null;

    /**
    * @var string A short description of the good
    */
    public $description = null;

    /**
    * @var int The market price of the good
    */
    public $marketprice = null;

    /**
    * @var int The sales price of the good
    */
    public $salesprice = null;

    /**
    * @var int The stock number of the good
    */
    public $housenum = null;

    /**
    * @var string The picarr of the good
    */
    public $picarr = "";

    /**
    * @var string The picurl of the good
    */
    public $picurl = "";

    /**
    * @var string The gender of the good
    */
    public $gender = null;

    /**
    * @var int The 3dflag of the good
    */
    public $modelflag = null;

    /**
    * @var string The rtype of the good
    */
    public $rtype = null;

    /**
    * @var string The rtype of the good
    */
    public $type = null;

    /**
    * @var string The size of the good
    */
    public $size = null; 

    /**
    * @var string The center_x of the good
    */
    public $center_x = null;

    /**
    * @var string The center_y of the good
    */
    public $center_y = null;

    /**
    * @var string The url of the tryon_pic of the good
    */
    public $tryon_pic_url = "";

    /**
    * Sets the object's properties using the values in the supplied array
    *
    * @param assoc The property values
    */

    public function __construct($data=array()) {
    	if (isset($data['id'])) {
    		$this->id = (int) $data['id'];
    	}
        if (isset($data['brandid'])) {
            $this->brandid = (int) $data['brandid'];
        }
    	if (isset($data['posttime'])) {
    		$this->posttime = (int) $data['posttime'];
    	}
    	if (isset($data['title'])) {
    		$this->title = $data['title'];
    	}
    	if (isset($data['description'])) {
    		$this->description = $data['description'];
    	}
    	if (isset($data['marketprice'])) {
    		$this->marketprice = $data['marketprice'];
    	}
    	if (isset($data['salesprice'])) {
    		$this->salesprice = $data['salesprice'];
    	}
    	if (isset($data['housenum'])) {
    		$this->housenum = $data['housenum'];
    	}
        if (isset($data['picarr'])) {
            $this->picarr = $data['picarr'];
        }
        if (isset($data['picurl'])) {
            $this->picurl = $data['picurl'];
        }
        if (isset($data['gender'])) {
            $this->gender = $data['gender'];
        }
        if(isset($data['modelflag'])) {
            $this->modelflag = $data['modelflag'];
        }
        if(isset($data['rtype'])) {
            $this->rtype = $data['rtype'];
        }
        if(isset($data['type'])) {
            $this->type = $data['type'];
        }
        if(isset($data['size'])) {
            $this->size = $data['size'];
        }
        if(isset($data['center_x'])) {
            $this->center_x = $data['center_x'];
        }
        if(isset($data['center_y'])) {
            $this->center_y = $data['center_y'];
        }
        if (isset($data['tryon_pic_url'])) {
            $this->tryon_pic_url = $data['tryon_pic_url'];
        }
    }

    /**
    * Sets the object's properties using the edit form post values in the supplied array
    *
    * @param assoc The form post values
    */

    public function storeFormValues($params) {
    	// Store all the parameters
    	$this->__construct($params);

    	// Parse and store the publication date
    	if (isset($params['posttime'])) { 
            $this->posttime = time();
    	}
    }

    /**
    * Stores any image uploaded from the edit form
    *
    * @param assoc The 'image' element from the $_FILES array containing the file upload data
    */

    public function storeUploadedImage($image) {
        if(!empty($image)){
            $allowedExts = array("gif", "jpeg", "jpg", "png");
    
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            //create directory if not exists
            $datefolder = '';
            $datefolder += date('Y').date('m').date('d');
            if (!file_exists('../uploads/image/'.$datefolder)) {
                mkdir('../uploads/image/'.$datefolder, 0777, true);
            }

            // Delete any previous image(s) for this good
            $this->deleteImages();

            $image_name = $image['name'];
            //get image extension
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            //assign unique name to image
            $name = time().'.'.$ext;
            //image size calcuation in KB
            $image_size = $image["size"] / 1024;
            $image_flag = true;
            //max image size
            $max_size = 512;
            if( in_array($ext, $allowedExts) && $image_size < $max_size ){
                $image_flag = true;
            } else {
                $image_flag = false;
                $data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
            } 
    
            if( $image["error"] > 0 ){
                $image_flag = false;
                $data['error'] = '';
                $data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$image["error"];
            }
    
            if($image_flag){
                if(move_uploaded_file($image["tmp_name"], "../uploads/image/".$datefolder.'/'.$name)){
                    echo "success in moving file";
                }
                else echo "fail in moving file";
                $src = "../uploads/image/".$datefolder.'/'.$name;
                $dist = "../uploads/image/".$datefolder.'/thumbnail_'.$name;
                $data['success'] = $thumbnail = 'thumbnail_'.$name;

                // Create the thumbnail
                $dis_width = 200;
                $img = '';
                $extension = strtolower(strrchr($src, '.'));
                switch($extension) {
                    case '.jpg':
                    case '.jpeg':
                        $img = @imagecreatefromjpeg($src);
                        break;
                    case '.gif':
                        $img = @imagecreatefromgif($src);
                        break;
                    case '.png':
                        $img = @imagecreatefrompng($src);
                        break;
                }
                $width = imagesx($img);
                $height = imagesy($img);

                $dis_height = $dis_width * ($height / $width);

                $new_image = imagecreatetruecolor($dis_width, $dis_height);
                imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);

                $imageQuality = 100;

                switch($extension) {
                    case '.jpg':
                    case '.jpeg':
                        if (imagetypes() & IMG_JPG) {
                            imagejpeg($new_image, $dist, $imageQuality);
                        }
                        break;

                    case '.gif':
                        if (imagetypes() & IMG_GIF) {
                            imagegif($new_image, $dist);
                        }
                        break;
    
                    case '.png':
                        $scaleQuality = round(($imageQuality/100) * 9);
                        $invertScaleQuality = 9 - $scaleQuality;

                        if (imagetypes() & IMG_PNG) {
                            imagepng($new_image, $dist, $invertScaleQuality);
                        }
                        break;
                }

                imagedestroy($new_image);
                $this->picarr = 'a:1:{i:0;s:38:"uploads/image/'.$datefolder.'/'.$name.',";}';
                $this->picurl = 'uploads/image/'.$datefolder.'/thumbnail_'.$name;
                $this->update();
            }
        } else {
            $data[] = 'No Image Selected..';
        }
    }

    public function storeUploadedTryonImage($tryon_image) {
        error_log(print_r($tryon_image), TRUE);
        if(!empty($tryon_image)){
            $allowedExts = array("gif", "jpeg", "jpg", "png");
    
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            //create directory if not exists
            $datefolder = '';
            $datefolder += date('Y').date('m').date('d');
            if (!file_exists('../uploads/image/'.$datefolder)) {
                mkdir('../uploads/image/'.$datefolder, 0777, true);
            }

            // Delete any previous tryon_image(s) for this good
            $this->deleteTryonImages();

            $image_name = $tryon_image['name'];
            //get image extension
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            //assign unique name to image
            $name = time().'.'.$ext;
            //image size calcuation in KB
            $image_size = $tryon_image["size"] / 1024;
            $image_flag = true;
            //max image size
            $max_size = 512;
            if( in_array($ext, $allowedExts) && $image_size < $max_size ){
                $image_flag = true;
            } else {
                $image_flag = false;
                $data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
            } 
    
            if( $tryon_image["error"] > 0 ){
                $image_flag = false;
                $data['error'] = '';
                $data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$tryon_image["error"];
            }
        
            if($image_flag){
                move_uploaded_file($tryon_image["tmp_name"], "../uploads/image/".$datefolder.'/tryon_pic_'.$name);
                $this->tryon_pic_url = 'uploads/image/'.$datefolder.'/tryon_pic_'.$name;
                $this->update();
            }
        } else {
            $data[] = 'No Image Selected..';
        }
    }
        
    /**
    * Deletes any images and/or thumbnails associated with the good
    */

    public function deleteImages() {
        if ($this->id && $this->picarr) {
            $picpath = '../';
            $firstpos = strpos($this->picarr, '"');
            $secondpos = strpos($this->picarr, '"', $firstpos + strlen('"'));
            for ($x = $firstpos + 1; $x <= $secondpos - 2; $x++) {
                $picpath .= $this->picarr[$x];
            }
            // Delete all fullsize images for this good
            if (!unlink($picpath)) {
                trigger_error("Good::deleteImages(): Couldn't delete image file.".$picpath, E_USER_ERROR);
            }
            // Remove the picarr from the object
            $this->picarr = "";
        }

        // Delete all thumbnail images for this good
        if ($this->id && $this->picurl) {
            $thumbnailpath = '../'.$this->picurl;
            if (!unlink($thumbnailpath)) {
                trigger_error("Good::deleteImages(): Couldn't delete thumbnail file.", E_USER_ERROR);
            }
            // Remove the picurl from the object
            $this->picurl = "";
        }       
    }

    public function deleteTryonImages() {
        //Delete tryon_pic for this good
        if ($this->id && $this->tryon_pic_url) {
            $tryon_picpath='../'.$this->tryon_pic_url;
            if (!unlink($tryon_picpath)) {
                trigger_error("Good::deleteTryonImages(): Couldn't delete image file.", E_USER_ERROR);
            }
            // Remove the picarr from the object
            $this->tryon_pic_url = "";
        }  
    }


    /**
    * Returns a relative path to the good's full-size or thumbnail image
    *
    * @param string The type of image path to retrieve (IMG_TYPE_FULLSIZE or IMG_TYPE_THUMB). Defaults to IMG_TYPE_FULLSIZE.
    * @return string|false The image's path, or false if an image hasn't been uploaded
    */

    public function getImagePath($type=IMG_TYPE_FULLSIZE) {
        if ($this->id && $this->picarr) {
            $picpath = '';
            $firstpos = strpos($this->picarr, '"');
            $secondpos = strpos($this->picarr, '"', $firstpos + strlen('"'));
            for ($x = $firstpos + 1; $x <= $secondpos - 2; $x++) {
                $picpath .= $this->picarr[$x];
            }
            return '../'.$picpath;
        } else {
            return false;
        }
    }

    public function getTryonImagePath($type=IMG_TYPE_FULLSIZE) {
        if ($this->id && $this->tryon_pic_url) {
            return '../'.$this->tryon_pic_url;
        } else {
            return false;
        }
    }

    /**
    * Returns a Good object matching the given good ID
    *
    * @param int The good ID
    * @return Good|false The good object, or false if the record was not found or there was a problem
    */

    public static function getById($id) {
    	$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    	
        $sql = "SELECT *, posttime AS posttime, tryon_pic AS tryon_pic_url FROM pmw_goods_tryon_pic WHERE goods_id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $newrow = $st->fetch();

        $sql = "SELECT *, posttime AS posttime FROM pmw_goods WHERE id = :id";
    	$st = $conn->prepare($sql);
    	$st->bindValue(":id", $id, PDO::PARAM_INT);
    	$st->execute();
    	$row = $st->fetch();

        if($newrow)
            $row = array_merge($newrow, $row);
    	$conn = null;
    	if ($row) {
    		return new Good($row);
    	}
    }

    /**
    * Returns all (or a range of) Good objects in the DB
    *
    * @param int Optional The number of rows to return (default=all)
    * @param string Optional column by which to order the goods (default="posttime DESC")
    * @return Array|false A two-element array : results => array, a list of Good objects; totalRows => Total number of goods
    */
    
    public static function getList($numRows = 1000000, $order = "posttime DESC") {
    	$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        if (isset($_SESSION['brandid'])) {
            $brandid = $_SESSION['brandid'];
    	    $sql = "SELECT SQL_CALC_FOUND_ROWS *, posttime AS posttime FROM pmw_goods WHERE brandid = ".$brandid."
    	        ORDER BY ".$order." LIMIT :numRows";
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS *, posttime AS posttime FROM pmw_goods 
                ORDER BY ".$order." LIMIT :numRows";
        }

    	$st = $conn->prepare($sql);
    	$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
    	$st->execute();
    	$list = array();

    	while($row = $st->fetch()) {
    		$good = new Good($row);
    		$list[] = $good;
    	}

    	// Now get the total number of goods that matched the criteria
    	$sql = "SELECT FOUND_ROWS() AS totalRows";
    	$totalRows = $conn->query($sql)->fetch();
    	$conn = null;
    	return (array("results" => $list, "totalRows" => $totalRows[0]));
    }

    /**
    * Inserts the current Good object into the database, and sets its ID property.
    */

    public function insert() {
    	// Does the Good object already have an ID?
    	if (!is_null($this->id)) {
    		trigger_error ("Good::insert(): Attempt to insert a Good object that already has its ID property set (to $this->id).", E_USER_ERROR);
    	}

    	// Insert the Good
    	$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    	$sql = "INSERT INTO pmw_goods (brandid, posttime, title, description, marketprice, salesprice, housenum, picarr, picurl) VALUES (:brandid, :posttime, :title, :description, :marketprice, :salesprice, :housenum, :picarr, :picurl)";
        $st = $conn->prepare($sql);
        $this->posttime = time();
        $st->bindValue(":posttime", $this->posttime, PDO::PARAM_INT);
        $this->brandid = $_SESSION['brandid'];
        $st->bindValue(":brandid", $this->brandid, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":marketprice", $this->marketprice, PDO::PARAM_INT);
        $st->bindValue(":salesprice", $this->salesprice, PDO::PARAM_INT);
        $st->bindValue(":housenum", $this->housenum, PDO::PARAM_INT);
        $st->bindValue(":picarr", $this->picarr, PDO::PARAM_STR);
        $st->bindValue(":picurl", $this->picurl, PDO::PARAM_STR);
        $st->execute();
        $this->id = $conn->lastInsertId();
        
        //Insert the Good to pmw_goods_tryon_pic
        $sql = "INSERT INTO pmw_goods_tryon_pic (posttime, goods_id, title, gender, 3dflag, rtype, type, size, center_x, center_y, description, tryon_pic) VALUES (:posttime, :id, :title, :gender, :modelflag, :rtype, :type, :size, :center_x, :center_y, :description, :tryon_pic_url)";
        $st = $conn->prepare($sql);
        $st->bindValue(":posttime", $this->posttime, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":gender", $this->gender, PDO::PARAM_STR);
        $st->bindValue(":modelflag", $this->modelflag, PDO::PARAM_INT);
        $st->bindValue(":rtype", $this->rtype, PDO::PARAM_STR);
        $st->bindValue(":type", $this->type, PDO::PARAM_STR);
        $st->bindValue(":size", $this->size, PDO::PARAM_INT);
        $st->bindValue(":center_x", $this->center_x, PDO::PARAM_STR);
        $st->bindValue(":center_y", $this->center_y, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":tryon_pic_url", $this->tryon_pic_url, PDO::PARAM_STR);
        
        $st->execute();

        $conn = null;
    }

    /**
    * Updates the current Good object in the database.
    */

    public function update() {
        // Does the Good object have an ID?
        if (is_null($this->id)) {
            trigger_error("Good::update(): Attempt to update a Good object that does not have its ID property set.", E_USER_ERROR);
        }

        // Update the Good
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE pmw_goods SET posttime = :posttime, title = :title, description = :description, picarr = :picarr, picurl = :picurl, marketprice = :marketprice, salesprice = :salesprice, housenum = :housenum WHERE id = :id AND brandid = :brandid";
        $st = $conn->prepare($sql);
        $this->posttime = time();
        $st->bindValue(":posttime", $this->posttime, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":marketprice", $this->marketprice, PDO::PARAM_INT);
        $st->bindValue(":salesprice", $this->salesprice, PDO::PARAM_INT);
        $st->bindValue(":housenum", $this->housenum, PDO::PARAM_INT);
        $st->bindValue(":picarr", $this->picarr, PDO::PARAM_STR);
        $st->bindValue(":picurl", $this->picurl, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":brandid", $this->brandid, PDO::PARAM_INT);
        $st->execute();

        //Update the Good to goods_tryon_pic
        $sql = "UPDATE pmw_goods_tryon_pic SET posttime = :posttime, title = :title, gender = :gender, 3dflag = :modelflag, rtype = :rtype, type = :type, size = :size, center_x = :center_x, center_y = :center_y, description = :description, tryon_pic = :tryon_pic_url WHERE goods_id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":posttime", $this->posttime, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":gender", $this->gender, PDO::PARAM_STR);
        $st->bindValue(":modelflag", $this->modelflag, PDO::PARAM_INT);
        $st->bindValue(":rtype", $this->rtype, PDO::PARAM_STR);
        $st->bindValue(":type", $this->type, PDO::PARAM_STR);
        $st->bindValue(":size", $this->size, PDO::PARAM_INT);
        $st->bindValue(":center_x", $this->center_x, PDO::PARAM_STR);
        $st->bindValue(":center_y", $this->center_y, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":tryon_pic_url", $this->tryon_pic_url, PDO::PARAM_STR);

        $st->execute();

        $conn = null;
    }

    /**
    * Deletes the current Good object from the database.
    */

    public function delete() {
        // Does the Good object have an ID?
        if (is_null($this->id)) {
            trigger_error("Good::delete(): Attempt to delete a Good object that does not have its ID property set.", E_USER_ERROR);
        }

        // Delete the Good
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare("DELETE FROM pmw_goods WHERE id = :id LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();

        //Delete the Good from pmw_goods_tryon_pic database
        $st = $conn->prepare("DELETE FROM pmw_goods_tryon_pic WHERE goods_id = :id LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();

        $conn = null;
    }

}

?>
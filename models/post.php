<?php

class Post {

// we define 12 attributes
    public $postid;
    public $userid;
    public $title;
    public $blurb;
    public $mainimage;
    public $content;
    public $rating;
    public $created;
    public $postviews;
    public $poststatus;

    function __construct($postid, $userid, $title, $blurb, $mainimage, $content, $rating, $created, $postviews, $poststatus) {
        $this->postid = $postid;
        $this->userid = $userid;
        $this->title = $title;
        $this->blurb = $blurb;
        $this->mainimage = $mainimage;
        $this->content = $content;
        $this->rating = $rating;
        $this->created = $created;
        $this->postviews = $postviews;
        $this->poststatus = $poststatus;
    }

    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM BLOG_POSTS');
// we create a list of Blog Post objects from the database results
        foreach ($req->fetchAll() as $post) {
            $list[] = new Post($post['PostID'], $post['UserID'], $post['Title'], $post['Blurb'], $post['MainImage'], $post['Content'], $post['DifficultyRating'], $post['Created'], $post['PostViews'], $post['PostStatus']);
        }
        return $list;
    }

    public static function find($id) {
        $db = Db::getInstance();
//use intval to make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM BLOG_POSTS WHERE PostID = :id');
//the query was prepared, now replace :id with the actual $id value
        $req->execute(array('id' => $id));
        $post = $req->fetch();
        if ($post) {
            return new Post($post['PostID'], $post['UserID'], $post['Title'], $post['Blurb'], $post['MainImage'], $post['Content'], $post['DifficultyRating'], $post['Created'], $post['PostViews'], $post['PostStatus']);
        } else {
//replace with a more meaningful exception
            throw new Exception("We couldn't find that blog post");
        }
    }

    public static function update($id) {
        $db = Db::getInstance();
        $req = $db->prepare("Update BLOG_POSTS set UserID=:userid, Title=:title, Blurb=:blurb, MainImage=:mainimage, Content=:content, DifficultyRating=:rating, PostStatus=:poststatus where PostID=:postid");
        $req->bindParam(':postid', $id);
        $req->bindParam(':userid', $userid);
        $req->bindParam(':title', $title);
        $req->bindParam(':blurb', $blurb);
        $req->bindParam(':mainimage', $mainimage);
        $req->bindParam(':content', $content);
        $req->bindParam(':rating', $rating);
        $req->bindParam(':poststatus', $poststatus);


// set parameters and execute
        if (isset($_POST['userid']) && $_POST['userid'] != "") {
            $filteredUserID = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $filteredTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['blurb']) && $_POST['blurb'] != "") {
            $filteredBlurb = filter_input(INPUT_POST, 'blurb', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['content']) && $_POST['content'] != "") {
            $filteredContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['rating']) && $_POST['rating'] != "") {
            $filteredRating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['poststatus']) && $_POST['poststatus'] != "") {
            $filteredPostStatus = filter_input(INPUT_POST, 'poststatus', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (!isset($_POST['blogpic']) && (!empty($_FILES[self::InputKey]['mainimage']))) {
            $mainimage = $_FILES[self::InputKey]['mainimage'];
        } else {
            $mainimage = 'views/images/blogpics/' . $filteredTitle . '.jpeg';
        }


        $userid = $filteredUserID;
        $title = $filteredTitle;
        $blurb = $filteredBlurb;
        $content = $filteredContent;
        $rating = $filteredRating;
        $poststatus = $filteredPostStatus;

        $req->execute();

        Post::uploadFile($title);
    }

    public static function add() {
        $db = Db::getInstance();
        $req = $db->prepare("INSERT INTO BLOG_POSTS(UserID, Title, Blurb, MainImage, Content, DifficultyRating) VALUES (:userid, :title, :blurb, :mainimage, :content, :rating)");
        $req->bindParam(':userid', $userid);
        $req->bindParam(':title', $title);
        $req->bindParam(':blurb', $blurb);
        $req->bindParam(':mainimage', $mainimage);
        $req->bindParam(':content', $content);
        $req->bindParam(':rating', $rating);


// set parameters and execute
        if (isset($_POST['userid']) && $_POST['userid'] != "") {
            $filteredUserID = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $filteredTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['blurb']) && $_POST['blurb'] != "") {
            $filteredBlurb = filter_input(INPUT_POST, 'blurb', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['content']) && $_POST['content'] != "") {
            $filteredContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['rating']) && $_POST['rating'] != "") {
            $filteredRating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $userid = $filteredUserID;
        $title = $filteredTitle;
        $blurb = $filteredBlurb;
        $mainimage = 'views/images/blogpics/' . $filteredTitle . '.jpeg';
        $content = $filteredContent;
        $rating = $filteredRating;

        $req->execute();

//upload post image
        Post::uploadFile($title);
    }

    const AllowedTypes = ['image/jpeg', 'image/jpg'];
    const InputKey = 'blogpic';

//die() function calls replaced with trigger_error() calls
//replace with structured exception handling
    public static function uploadFile(string $name) {

        if (empty($_FILES[self::InputKey])) {
//die("File Missing!");
            trigger_error("File Missing!");
        }
    }
       // if ($_FILES[self::InputKey]['error'] > 0) {
       //     trigger_error("Handle the error! " . $_FILES[InputKey]['error']);
       // }


     //   if (!in_array($_FILES[self::InputKey]['type'], self::AllowedTypes)) {
     //       trigger_error("File Type Not Allowed: " . $_FILES[self::InputKey]['type']);
     //   }

    //    $tempFile = $_FILES[self::InputKey]['tmp_name'];
    //    $path = __DIR__ . "../../views/images/blogpics/";
    //    $destinationFile = $path . $name . '.jpeg';

    //    if (!move_uploaded_file($tempFile, $destinationFile)) {
    //        trigger_error("Handle Error");
    //    }

//Clean up the temp file
 //       if (file_exists($tempFile)) {
 //           unlink($tempFile);
 //       }
 //   }

    public static function remove($id) {
        $db = Db::getInstance();
//make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('DELETE FROM BLOG_POSTS WHERE PostID = :id');
// the query was prepared, now replace :id with the actual $id value
        $req->execute(array('id' => $id));
    }

}

?>
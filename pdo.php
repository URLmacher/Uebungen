<?php
    $host = 'localhost';
    $user = 'Admin';
    $password = '12345';
    $dbname = 'pdo_posts';

    #SET DSN
    $dsn = 'mysql:host='.$host.';dbname='.$dbname;

    #PDO Instance
    $pdo = new PDO($dsn,$user,$password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

    #PDO Query
    // $stmt = $pdo->query('SELECT * FROM posts');

    // while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     echo $row['title'] . '<br>';
    // }

    // while($row = $stmt->fetch()) {
    //     echo $row->title . '<br>';
    // }

    $author = 'Patrick';
    $is_published = true;
    $id = 5;
    $limit =1;
    #Prepared Statements (prepare & execute)

    //UNSAFE
        // $sql = "SELECT * FROM posts WHERE author = '$author'";

    //FETCH MULTIPLE
    //POSITIONAL PARAMS
        $sql = 'SELECT * FROM posts WHERE author = ? && is_published = ? LIMIT ?';
        $stmt = $pdo->prepare($sql);
        $author = 'Patrick';
        $stmt->execute([$author,$is_published,$limit]);
        $posts = $stmt->fetchAll();
    
    //NAMED PARRAMS
        // $sql = 'SELECT * FROM posts WHERE author = :author && is_published = : is_published';
        // $stmt = $pdo->prepare($sql);
    
        // $stmt->execute(['author' => $author, 'is_published' => $is_published]);
        // $posts = $stmt->fetchAll();

        foreach($posts as $post) {
            echo $post->title . '<br>';
         }

    //FETCH SINGLE POST
        // $sql = 'SELECT * FROM posts WHERE id = :id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(['id' => $id]);
        // $post = $stmt->fetch();
        // echo $post->body;

    //GET ROW COUNT
        // $stmt = $pdo->prepare('SELECT*FROM POSTS WHERE author = ?');
        // $stmt->execute([$author]);
        // $postCount = $stmt->rowCount();

        // echo $postCount;
    //INSERT DATA
        // $title = 'Poster';
        // $body = 'THis is a Post';
        // $author = 'Kevin';

        // $sql = 'INSERT INTO posts(title, body, author) VALUES(:title, :body, :author)';
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(['title' => $title, 'body' => $body, 'author' => $author]);
        // echo 'Postiert';
    //UPDATE DATA
        // $id = 1;
        // $body = 'THis is a updated Post';
        // $author = 'Kevin';

        // $sql = 'UPDATE posts SET body = :body WHERE id = :id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(['body' => $body, 'id' => $id]);
        // echo 'Postiert updati';
    //DELTE DATA
        // $id = 1;
        // $sql = 'DELETE FROM posts WHERE id = :id';
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(['id' => $id]);
        // echo 'Post Deleti';
    //SEARCH DATA
        // $search = "%post%";
        // $sql = 'SELECT * FROM posts WHERE title LIKE ?';
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([$search]);
        // $posts = $stmt->fetchAll();

        // foreach($posts as $post){
        //     echo $post->title."<br>";
        // }
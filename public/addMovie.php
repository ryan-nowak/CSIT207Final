<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_movie = array(
            "MOVIES_NAME" => $_POST['mediaName'],
            "MOVIES_SS" => $_POST['mediaSS'],
            "MOVIES_COMPLETE" => $_POST['mediaComplete']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "MOVIES",
                implode(", ", array_keys($new_movie)),
                ":" . implode(", :", array_keys($new_movie))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_movie);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['mediaName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add Movie</h2>

<form method="post">
    <label for="mediaName">Name of Movie</label>
    <input type="text" name="mediaName" id="mediaName">
    <label for="mediaSS">Movie's Streaming Service</label>
    <input type="text" name="mediaSS" id="mediaSS">
    <label for="mediaComplete">Completed?</label>
    <select name="mediaComplete" id="mediaComplete">
        <option value=0>False</option>
        <option value=1>True</option>
    </select>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_show = array(
            "TV_NAME" => $_POST['mediaName'],
            "TV_SS" => $_POST['mediaSS'],
            "TV_COMPLETE" => $_POST['mediaComplete']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "TELEVISION",
                implode(", ", array_keys($new_show)),
                ":" . implode(", :", array_keys($new_show))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_show);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['mediaName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add TV Show</h2>

<form method="post">
    <label for="mediaName">Name of Show</label>
    <input type="text" name="mediaName" id="mediaName">
    <label for="mediaSS">Show's Streaming Service</label>
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

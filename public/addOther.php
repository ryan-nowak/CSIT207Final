<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_other = array(
            "OTHER_NAME" => $_POST['mediaName'],
            "OTHER_SS" => $_POST['mediaSS'],
            "OTHER_COMPLETE" => $_POST['mediaComplete']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "OTHER",
                implode(", ", array_keys($new_other)),
                ":" . implode(", :", array_keys($new_other))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_other);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['mediaName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add Other Media Content</h2>

<form method="post">
    <label for="mediaName">Name of Other Media Content</label>
    <input type="text" name="mediaName" id="mediaName">
    <label for="mediaSS">Other Media Content's Streaming Service</label>
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

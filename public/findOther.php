<?php
if (isset($_POST['submit'])) {
    try  {
        
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM OTHER
                        WHERE OTHER_NAME = :mediaName";

        $mediaName = $_POST['mediaName'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':mediaName', $mediaName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Other Media Content ID</th>
                    <th>Other Media Content's Name</th>
                    <th>Other Media Content's Streaming Service</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["OTHER_ID"]); ?></td>
                <td><?php echo escape($row["OTHER_NAME"]); ?></td>
                <td><?php echo escape($row["OTHER_SS"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['mediaName']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find Other Media Content in database based on name</h2>

<form method="post">
    <label for="mediaName">Other Media Content Name</label>
    <input type="text" id="mediaName" name="mediaName">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

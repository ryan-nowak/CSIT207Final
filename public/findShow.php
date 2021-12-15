<?php
if (isset($_POST['submit'])) {
    try  {
        
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM TELEVISION
                        WHERE TV_NAME = :mediaName";

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
                    <th>TV Show ID</th>
                    <th>TV Show Name</th>
                    <th>TV Show's Streaming Service</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["TV_ID"]); ?></td>
                <td><?php echo escape($row["TV_NAME"]); ?></td>
                <td><?php echo escape($row["TV_SS"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['mediaName']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find TV Show in database based on name</h2>

<form method="post">
    <label for="mediaName">TV Show Name</label>
    <input type="text" id="mediaName" name="mediaName">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

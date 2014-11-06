<?php
$stmt = $db->prepare('INSERT INTO users (name, email, created) ' .
    'VALUES (:name, :email, NOW())');
$stmt->execute(array(
    'name' => $_POST['requester_name'],
    'email' => $_POST['requester_email']
));
$id = $db->lastInsertId();
 
$key = $store->updateConsumer($_POST, $id, true);
$c = $store->getConsumer($key, $id);
?>
<p><strong>Save these values!</strong></p>
<p>Consumer key: <strong><?=$c['consumer_key']; ?></strong></p>
<p>Consumer secret: <strong><?=$c['consumer_secret']; ?></strong></p>
<?php

use Dom\Mysql;

class Review
{
private $conn;

public function __construct($db)
{
    $this->conn = $db;
}



// Add Review
public function addReview($user_id,$product_id,$rating,$review)
{
$sql = "INSERT INTO reviews
(user_id,product_id,rating,review)
VALUES (?,?,?,?)";

$stmt = $this->conn->prepare($sql);
$stmt->bind_param(
"iiis",
$user_id,
$product_id,
$rating,
$review
);
return $stmt->execute();
}




// Get Product Reviews
public function getReviews($product_id)
{
$sql = "
SELECT 
reviews.*,
users.fullname
FROM reviews
JOIN users
ON reviews.user_id = users.id
WHERE product_id = ?
ORDER BY created_at DESC
";

$stmt = $this->conn->prepare($sql);
$stmt->bind_param(
"i",
$product_id
);
$stmt->execute();
return $stmt->get_result();
}

// Average Rating
public function averageRating($product_id){
$sql = "
SELECT AVG(rating) AS average
FROM reviews
WHERE product_id = ?
";

$stmt = $this->conn->prepare($sql);
$stmt->bind_param(
"i",
$product_id
);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
return round($row['average'] ?? 0,1);
}
}

?>
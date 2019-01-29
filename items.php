<?php
$site_root = '/demos/2019/ajax-navigation';
?>
				<h3>ITEMS PAGE</h3>
				<p>
					If no ID is used, the items list goes here and only this portion gets loaded into the content-fill div if the items link is clicked or someone visits www.sitename.com/items.
					<br>
					<br>
					The list would look something like:
					<br>
					<br>
<nav>
					<a href="<?=$site_root?>/items/1">Item 1</a>
					<br>
					<a href="<?=$site_root?>/items/2">Item 2</a>
</nav>
					<br>
					<br>
					The item list and IDs would be grabbed from a MySQL database.
				</p>
				<p>
					If an ID is used, the specific item goes here and only this portion gets loaded into the content-fill div if an item with an ID is clicked or someone visits www.sitename.com/items/1.
				</p>
				<p>
				</p>
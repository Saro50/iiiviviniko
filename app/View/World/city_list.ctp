<!-- 
    $data from $queryStr 
-->
<?php echo $this->Html->link("back", "/world"); ?>
<h1>All City</h1>
<table>

    <tr>
        <th>Name</th>
        <th>CountryCode</th>
        <th>District</th>
        <th>Population</th>
    </tr>
    <?php foreach ($cities as $city): ?>
    <tr>
       <td><?php echo $city['City']['Name']; ?></td>
        <td><?php echo $city['City']['CountryCode'] ;?> </td>
        <td><?php echo $city['City']['District']; ?></td>
        <td><?php echo $city['City']['Population']; ?></td>
    </tr>
    <?php endforeach;?>
     <?php unset($city); ?>
</table>
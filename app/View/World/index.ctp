

<h1>All Country</h1>
<table>
    <tr>
        <th>Code</th>
        <th>Region</th>
        <th>Name</th>
        <th>IndepYear</th>
        <th>Population</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->
    <?php foreach ($countres as $country): ?>

    <tr>
        <td><?php echo $country['Country']['Code']; ?></td>
        <td><?php echo $country['Country']['Region'] ;?> </td>
        <td><?php echo $this->Html->link($country['Country']['Name'], "city?code=".$country['Country']['Code'] ); ?> </td>
        <td><?php echo $country['Country']['IndepYear']; ?></td>
        <td><?php echo $country['Country']['Population']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($country); ?>
</table>
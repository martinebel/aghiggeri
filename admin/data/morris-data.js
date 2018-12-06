$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [
			  <?php
					$stmt = $dbh->prepare("SELECT count(*) as total FROM `categorias`");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo "{period: 'Mes: ".$row['mes']."',pedidos: ".$row['total']."},";
		}
		?>
            
         ],
        xkey: 'period',
        ykeys: ['pedidos'],
        labels: ['Pedidos'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
    
});

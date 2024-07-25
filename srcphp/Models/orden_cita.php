<?php

namespace proyecto\Models;
use proyecto\Response\Success;
use proyecto\Models\Table;


class orden_cita extends Models{

    protected $filable = ["id_orden_cita","fecha_cita","fecha_hora","id_cliente","producto","problema","fecha_registro","asistencia", "cancelacion"];
    protected $table = "orden_cita";

public function mostrarOrden(){

    $TableOrden = new table();
    $allOrden = $TableOrden->query("

    SELECT
    CONCAT(p.nombre, ' ', p.apellido_paterno) AS nombre_cliente,
    oc.producto,
    oc.problema,
    'Orden de Cita' AS tipo_orden
FROM
    orden_cita oc
    INNER JOIN clientes c ON oc.id_cliente = c.id_cliente
    INNER JOIN persona p ON c.id_persona = p.id_persona

UNION

SELECT
    CONCAT(of.nombre, ' ', of.apellido_paterno) AS nombre_cliente,
    of.producto,
    of.problema,
    'Orden Física' AS tipo_orden
FROM
    orden_fisica of
    INNER JOIN asignacion_fisica af ON of.id_orden_fisica = af.id_orden_fisica
    INNER JOIN tecnico t ON af.id_tecnico = t.id_tecnico
    INNER JOIN empleado e ON t.id_empleado = e.id_empleado
    INNER JOIN persona p ON e.id_persona = p.id_persona
WHERE
    af.id_tecnico = 4;
");

$success = new Success( $allOrden);
return $success->Send();


}
}
<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2017 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

echo 'CiscoSB';

$multiplier = 1;
$divisor = 1;
foreach ($pre_cache['ciscosb_rlPhyTestGetResult'] as $index => $ciscosb_data) {
    foreach ($ciscosb_data as $key => $value) {
        if (! isset($value['rlPhyTestTableTransceiverTemp'])) {
            continue;
        }

        $oid = '.1.3.6.1.4.1.9.6.1.101.90.1.2.1.3.' . $index . '.5';
        $sensor_type = 'rlPhyTestTableTransceiverTemp';
        $port = PortCache::getByIfIndex(preg_replace('/^\d+\./', '', $index), $device['device_id']);
        $descr = trim($port?->ifDescr . ' Module');

        $temperature = $value['rlPhyTestTableTransceiverTemp'];
        $entPhysicalIndex = $index;
        $entPhysicalIndex_measured = 'ports';
        if (is_numeric($temperature) && ($value['rlPhyTestTableTransceiverSupply'] != 0)) {
            discover_sensor(null, 'temperature', $device, $oid, $index, $sensor_type, $descr, $divisor, $multiplier, null, null, null, null, $temperature, 'snmp', $entPhysicalIndex, $entPhysicalIndex_measured);
        }
    }
}

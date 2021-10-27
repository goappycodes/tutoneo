<?php

use App\Models\Booking;

$booking = Booking::find_by_ref($_POST['booking']);

if (!$booking) {
    show_404();
    exit;
}

$responses = $booking->user()->get_dominant_memory_responses();
?>
<table class="table table-bordered table-striped table-sm">
    <tbody>
    <?php foreach ($responses as $label => $response): ?>
        <tr>
            <th><?php echo $label ?></th>
            <td><?php echo $response; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
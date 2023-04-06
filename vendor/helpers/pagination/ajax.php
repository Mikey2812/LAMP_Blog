<div class="col-sm-5"><div class="dataTables_info" id="table_info" role="status" aria-live="polite">
	<?= "Showing page $nocurp, from $from to $to of $norecords entries"; ?>
</div></div>

<div class="col-sm-7">
	<div class="dataTables_paginate paging_simple_numbers" id="table_paginate">
		<ul class="pagination pull-right">
			<li class="paginate_button previous disabled" id="table_previous">
				<a href="javascript:void(0);" aria-controls="example1" data-dt-idx="<?=($curp-1); ?>" tabindex="0">Previous</a>
			</li>

			<?php for($i = 1; $i <= $nopages; $i++){ ?>
			<li class="paginate_button <?php if($i==$curp) echo('active') ?>">
				<a href="javascript:void(0);" aria-controls="example1" data-dt-idx="<?php echo($i); ?>" tabindex="0"><?php echo($i); ?></a>
			</li>
			<?php } ?>

			<li class="paginate_button next" id="table_next">
				<a href="javascript:void(0);" aria-controls="example1" data-dt-idx="<?=($curp+1); ?>" tabindex="0">Next
				</a>
			</li>
		</ul>
	</div>
</div>
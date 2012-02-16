<div id="menu">
	<script>
	function loadMenuList() {
		$("#edit-menu-form-content").html("Loading...");
		$.ajax({
			type: 'POST',
			url: '<?php echo HTTP_SERVER."front/menu/index"?>',
			success: function(data) {
				$("#edit-menu-form-content").html(data);
			},
			error: function(request, textStatus, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText + error);
			}	
		});
	}

	function loadNewMenu() {
		$("#edit-menu-form-content").html("Loading...");
		$.ajax({
			type: 'POST',
			url: '<?php echo HTTP_SERVER."front/menu/new"?>',
			success: function(data) {
				$("#edit-menu-form-content").html(data);
			},
			error: function(request, textStatus, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText + error);
			}	
		});
	}

	function showSortMenu() {
		$("#edit-menu-form-content").html("Loading...");
		$.ajax({
			type: 'POST',
			url: '<?php echo HTTP_SERVER."front/menu/sort"?>',
			success: function(data) {
				$("#edit-menu-form-content").html(data);
			},
			error: function(request, textStatus, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText + error);
			}	
		});
	}
	
	$(function(){	
		$("#menu-manager").button().click(function() {
			$("#edit-menu-form-content").html("Loading...");
			$("#menu-manager-form").dialog("open");
			$.ajax({
				type: 'POST',
				url: '<?php echo HTTP_SERVER."front/menu/index"?>',
				success: function(data) {
					$("#edit-menu-form-content").html(data);
				},
				error: function(request, textStatus, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText + error);
				}	
			});
		});

		$("#menu-manager-form").dialog({
			autoOpen: false,
			height: 600,
			width: 800,
			modal: true,
			buttons: {
				"Menu List": function() {
					loadMenuList();
				},
				"Sort Menu": function() {
					showSortMenu();
				},
				"New Menu": function () {
					loadNewMenu();
				},
				"Close": function() {
					$("#edit-menu-form-content").empty();
					$(this).dialog("close");
				}
			}
		});
	});
	</script>
	
	<div class="edit-button">
		<button id='menu-manager' class="state-changable-button" style="z-index:600;">...</button>
	</div>
	
	<div id="menu-manager-form" title="Menu Manager">
		<div id="edit-menu-form-content">
		</div>
	</div>
	<ul id="nav">
	<?php
	showMenu($menu_data['children'], 0);
	
	function showMenu($menu, $level) {
		foreach($menu as $data) {
			if($level == 0) {
			?>
				<li class="top"><a href="<?php echo $data['link'];?>" id="<?php echo "mnu".$data['name'];?>" class="top_link">
				<?php
				if(isset($data['children']) && $data['children'] != null) { 
				?>
					<span class="down"><?php echo $data['name']?></span></a>
					<ul class="sub">
						<?php showMenu($data['children'], $level + 1)?>
					</ul>
				<?php
				} else {
				?>
					<span><?php echo $data['name']?></span></a>
				<?php
				}
				?>
				</li>
			<?php
			}
			else {
			?>
				<li>
				<?php
				if(isset($data['children']) && $data['children'] != null) { 
				?>
					<a href="<?php echo $data['link'];?>" id="<?php echo "mnu".$data['name'];?>" class="fly">
					<?php echo $data['name']?>
					</a>
					<ul>
						<?php showMenu($data['children'], $level + 1)?>
					</ul>
				<?php
				} else {
				?>
					<a href="<?php echo $data['link'];?>" id="<?php echo "mnu".$data['name'];?>">
					<?php echo $data['name']?></a>
				<?php
				}
				?>
				</li>
			<?php
			}
		}
	}
	?>
	</ul>
</div>
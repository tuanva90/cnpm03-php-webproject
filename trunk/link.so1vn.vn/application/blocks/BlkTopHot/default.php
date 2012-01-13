<?php if ($hots) { ?>
  <div class="top-hot">
     <div class="title">Top LinkHay</div>
     <div class="hot-content">
     	<?php foreach($hots as $hot) { ?>
        <div class="item">
			<div class="left">
				<div class="good"><?php echo $hot['hot'];?></div>
				<div class="mark">điểm</div>
			</div>
			<div class="right">
			  <img width="30" height="30" src="<?php echo $hot['image'];?>" alt="<?php echo $hot['title'];?>">
              <div><a href="<?php echo $view->baseUrl('/comment/index/link_id/' . $hot['link_id']);?>" title="<?php echo $hot['title'];?>"><?php echo $hot['title'];?></a></div>
			</div>
     	</div>
        <?php } ?>
     </div>
  </div>
<?php  } ?>

				<h3 class="home">Post Details</h3> <hr>
				<div class="mb-5px"></div>
				<article class="postcontent">
					<?php
						foreach ($postById as $key => $value) {
					?>
					<div class="details">
						<div class="title">
							<h2><?php echo $value['title']; ?></h2>
							<p>Category :<a href="<?php echo BASE_URL;?>Index/postByCat/<?php echo $value['cat'];?>"><?php echo $value['name']; ?></a></p>
						</div>
						<div class="desc">
							<p><?php echo $value['content']; ?></p>
						</div>
					</div>
				<?php } ?>
				</article>
				



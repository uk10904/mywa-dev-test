<?php if($r->post_type == 'services_links') { $url = get_field('url', $r->id); $r->link = $url; if (empty($r->image)) { $r->image = '/govportal/wp-content/uploads/2016/11/myWA-logo.png';} } ?>
ALTER TABLE `title` 
	CHANGE title_uid title_id enum('2gw','adv','ams','bm','bed','dsm','ico','liv','lsm','nlt','ran','sau','sma','wei');

ALTER TABLE `title` CHANGE title_title_j j_title enum('2-Gun Western Novels','Adventure','Amazing Stories','Bedtime Tales','Detective Story Magazine','I Confess','Live Stories','Love Story Magazine','Night Life Tales','Ranch Romances','Saucy Stories','The Black Mask','The Smart Set','Weird Tales');

alter table `title` change title_url url enum('adventure_page','amazingstories_page','black_mask_page','contexts_pages/girlie_pulps','contexts_pages/pulp_slicks/slicks','detectivestory_page','i_confess_page','livestories_page','love_story_page','ranch_romances_page','saucy_page','two_gun_western_page','weird_tales_page');

alter table `title` change title_format_size size_format enum('oversize','standard','undersize');

alter table `title` change title_format_paper paper_format enum('glossy insert','mixed','pulp');

alter table `title` change title_pub_freq frequency enum('bi-monthly','irregular','monthly','weekly');

alter table `title` change title_total_dig digitized_copy enum('1','2','3','4','6','10','12','22');

alter table `title` change title_total_pub published_copy enum('100','1057','1172','129','166','209','279','340','365','609','881','886','Unknown');

alter table `title` change genre_p primary_genre enum('adventure','detective','fantasy','romance','science fiction','smart fiction','western');

alter table `title` change genre_s secondary_genre enum('adventure','flapper','girlie','horror','love','mystery','romance','various');
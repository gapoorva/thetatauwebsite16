<?php 
  /*
    STATS SECTION
      Takes: 
        stats: a php associative array that holds stats lables and their values:
        [
          'count_actives' => #,
          'count_actives_majors' => #,
          'percent_female_active_brothers' => #,
          'count_alumni' => #,
          'count_alumni_companies' => #,
          'count_alumni_cities' => #,
          'chapter_age' => #,
          'chapter_number' => #,
          'events_this_semester' => #
        ]
      Sends:
        A stats section displaying stats passed
  */

  function statstemplate($stats) {
    
?>
    <div class="container-fluid stats">
      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
          <div class="row opensans">
            <div class="col-sm-4 members-stats">
              <h4 class="stats-title members-stats text-center">MEMBERS</h4>
              <span class="statistic"><?php echo $stats['count_actives'] ?></span><p class="statistic-name lead">Active Brothers</p>
              <span class="statistic"><?php echo $stats['count_actives_majors'] ?></span><p class="statistic-name lead">Majors</p>
              <span class="statistic"><?php echo $stats['percent_female_active_brothers'] ?><span class="percent">%</span></span><p class="statistic-name lead">Female Gender Ratio</p>
            </div>
            <div class="col-sm-4 alumni-stats">
              <h4 class="stats-title alumni-stats text-center">ALUMNI</h4>
              <span class="statistic"><?php echo $stats['count_alumni'] ?></span><p class="statistic-name lead">Total Alumni</p>
              <span class="statistic"><?php echo $stats['count_alumni_companies'] ?></span><p class="statistic-name lead">Companies</p>
              <span class="statistic"><?php echo $stats['count_alumni_cities'] ?></span><p class="statistic-name lead">Cities</p>
            </div>
            <div class="col-sm-4 chapter-stats">
              <h4 class="stats-title chapter-stats text-center">CHAPTER</h4>
              <span class="statistic"><?php echo $stats['chapter_age'] ?></span><p class="statistic-name lead">Years Old</p>
              <span class="statistic"><?php echo $stats['chapter_number'] ?><span class="percent">st</span></span><p class="statistic-name lead">Chapter Nationally</p>
              <span class="statistic"><?php echo $stats['events_this_semester'] ?></span><p class="statistic-name lead">Events this semester</p>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php    
  }
?>
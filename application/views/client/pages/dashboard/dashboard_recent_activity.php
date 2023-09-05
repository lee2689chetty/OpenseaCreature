<?php
/**
 * Created by PhpStorm.
 * User: rock
 * Date: 24/10/2017
 * Time: 9:28 AM
 */?>
    <div class="timeline  white-bg ">
        <?php foreach ($dispArray as $dispItem):?>
            <?php if($dispItem['DispType'] == 'received'):?>
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <div class="timeline-icon">
                            <i class="icon-check font-blue-madison"></i>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"> </div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <span class="timeline-body-alerttitle font-blue-madison"> <?php echo $dispItem['Title'];?> </span>
                                <span class="timeline-body-time font-grey-cascade"><?php echo date('Y-m-d H:m:s', $dispItem['DateOccur']);?></span>
                            </div>
                        </div>
                        <div class="timeline-body-content">
                        <span class="font-grey-cascade"> <?php echo $dispItem['Content'];?> </span>
                        </div>
                    </div>
                </div>
            <?php elseif($dispItem['DispType'] == 'account'):?>
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <div class="timeline-icon">
                            <i class="icon-user-following font-blue-madison"></i>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"> </div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <span class="timeline-body-alerttitle font-blue-madison"> <?php echo $dispItem['Title'];?> </span>
                                <span class="timeline-body-time font-grey-cascade"><?php echo date('Y-m-d H:m:s', $dispItem['DateOccur']);?></span>
                            </div>
                        </div>
                        <div class="timeline-body-content">
                        <span class="font-grey-cascade"> <?php echo $dispItem['Content'];?>
                        </span>
                        </div>
                    </div>
                </div>
            <?php elseif($dispItem['DispType'] == 'transfer'):?>
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <div class="timeline-icon">
                            <i class="icon-users font-green-haze"></i>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"> </div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <span class="timeline-body-alerttitle font-green-haze"> <?php echo $dispItem['Title'];?></span>
                                <span class="timeline-body-time font-grey-cascade"><?php echo date('Y-m-d H:m:s', $dispItem['DateOccur']);?></span>
                            </div>
                        </div>
                        <div class="timeline-body-content">
                            <span class="font-grey-cascade"> <?php echo $dispItem['Content'];?> </span>
                        </div>
                    </div>
                </div>
            <?php elseif($dispItem['DispType'] == 'message'):?>
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <div class="timeline-icon">
                            <i class="icon-info font-red-intense"></i>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"> </div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <span class="timeline-body-alerttitle font-red-intense"><?php echo $dispItem['Title'];?></span>
                                <span class="timeline-body-time font-grey-cascade"><?php echo date('Y-m-d H:m:s', $dispItem['DateOccur']);?></span>
                            </div>
                        </div>
                        <div class="timeline-body-content">
                                                    <span class="font-grey-cascade"> <?php echo $dispItem['Content'];?>
                                                    </span>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
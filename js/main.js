/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.advertiseRunJobClass').on('click',runjob);

function runjob(){
    
    var mid=$(this).data('mid');
    //console.info(mid);
    $('body').css('cursor', 'wait');
    showJobRunning(mid);
}

function showJobRunning(mid){
    $('#jobRunningInfo'+mid).removeClass('hidden');
}

function showJobCompleted(mid){
    $('body').css('cursor', 'auto');
    $('#jobRunningInfo'+mid).addClass('hidden');
    $('#jobCompletedInfo'+mid).removeClass('hidden');
}
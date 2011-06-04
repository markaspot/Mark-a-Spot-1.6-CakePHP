<?php
class VotingHelper extends AppHelper {  
  /**
   * Formats a text in replacing the option wildcard(s).
   * 
   * @param $text Text with wildcards
   * @param $result Voting result
   * @param $wildcard One option wildcard to replace
   * @return unknown_type
   */
  function format($text, $result, $wildcard = '') {
    $voteCount = 0;
    $percentCount = 0;
    $percent = 0;
    
    foreach ($result as $votes) {
      $voteCount += $votes;
    }
    
    if (empty($wildcard)) {
      // replace votes wildcard
      $text = str_replace('#VOTES#', $voteCount, $text);
      
      // replace option votes wildcards
      foreach ($result as $wildcard => $votes) {
        if ($voteCount > 0) {
          $percent = number_format((100 / $voteCount) * $votes, 0);
        }
        
        $percentCount += $percent;
        
        $text = str_replace('#'.$wildcard.'#', $votes, $text);
        $text = str_replace('%'.$wildcard.'%', $percent, $text);
      }
    } else {
      // replace option votes wildcard
      if ($voteCount > 0) {
        $percent = number_format((100 / $voteCount) * $result[$wildcard], 0);
      }
      
      $percentCount += $percent;
      
      $text = str_replace('#VOTES#', $result[$wildcard], $text);
      $text = str_replace('%VOTES%', $percent, $text);
      
    }
    
    return $text;
  }
  
  /**
   * Checks if an option number matches the user vote.
   * 
   * @param $nr Option number
   * @param $vote User vote
   * @return 'true' if option number is user vote, 'false' otherwise.
   */
  function isUserVote($nr, $vote) {
    $isUserVote = isset($vote['Vote']['option']) && $nr == $vote['Vote']['option'];
    
    return $isUserVote;
  }
}
?>
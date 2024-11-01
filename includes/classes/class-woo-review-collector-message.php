<?php


class Woo_Review_Message
{
	public function infoMessage1()
	{
		$html=<<<EOD
        <table class="widefat fixed">
        <tbody>
        <tr>
        	<td align="center"><b><a target="_blank" style="color:#ee264a;" href="https://goo.gl/abdVVu">GET PREMIUM</a></b></td>
            <td align="center"><b style="display: none"><a target="_blank" style="color:#0073aa;" href="http://webappick.helpscoutdocs.com/">DOCUMENTATION</a></b></td>
            <td align="center"><b style="display: none"><a style="color:#ee264a;" target="_blank" href="https://www.youtube.com/playlist?list=PLapCcXJAoEenI-35wc6YnnsAAgoYRxDr7">VIDEOS TUTORIALS</a></b></td>
            <td align="center"><b><a target="_blank" style="color:#0DD41E;" href="https://webappick.com/support/">SUPPORT ( support@webappick.com )</a></b></td>
        </tr>
        </tbody>
    </table><br>
EOD;
		return $html;
	}
}

function WRC_ReviewMessage(){
	return new Woo_Review_Message();
}
<div style="font-weight: bold; font-size: 30px; line-height: 32px; color: #333" align="center">
    Someone wants to join your site!
</div><br>
<hr/>
<br>
Hi there! <strong><?=$vars['user']->title?></strong> has asked to join
<a href="<?=\Idno\Core\site()->config()->getDisplayURL()?>" style="color: #73b2e3; text-decoration: none;"><?=\Idno\Core\site()->config()->title?></a>.
<br><br>
They will need your approval before they can log in.
<br><br>
To approve or reject their request, log into the User Membership admin panel:
<br><br>
<div align="center">
    <a href="<?=\Idno\Core\site()->config()->getDisplayURL()?>admin/applytojoin/" style="background-color:#73B2E3;border:1px solid #73B2E3;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:17px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Manage Requests</a>
</div>
<br>
You can retrieve their email address from this page.
<br><br>
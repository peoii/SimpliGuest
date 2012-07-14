<form name="adminform" action="admin.php" method="POST">
<input type="hidden" name="func" value="5" />
<input type="hidden" name="loggedip" value="{field_gb_loggedip}" />
<input type="hidden" name="timestamp" value="{field_gb_timestamp}" />

<div style="padding: 4px 4px 4px 4px; border-width: 1px 2px 2px 1px; background: #f8f8f8; border-color: #e8e8e8; color: #000000; margin: 1em 0em 1em 0em; display: block; border-style: solid;">
<table style="border: 0px; width: 90%;" cellspacing="0">
  <tr>
    <td colspan="2">
    <div style="padding: 4px 4px 4px 4px; border-width: 1px 2px 2px 1px; background: #fbfbfb; border-color: #ebebeb; color: #000000; margin: 1em 0em 1em 0em; display: block; border-style: solid;">
      <sub>{field_gb_timestamp}</sub><br />
      <input type="checkbox" name="deleteentry" value="1" />Delete this Entry
    </div>
    </td>
  </tr>
  <tr>
    <td style="width: 20%;">
      Name: <input type="text" value="{field_gb_name}" name="name" /><br />
      <sub>
      Website: <input type="text" value="{field_gb_website}" name="website" /><br />
      Email: <input type="text" value="{field_gb_email}" name="email" /><br />
      ICQ: <input type="text" value="{field_gb_icq}" name="icq" /><br />
      AIM: <input type="text" value="{field_gb_aim}" name="aim" /><br />
      YAHOO: <input type="text" value="{field_gb_yahoo}" name="yahoo" /><br />
      MSN: <input type="text" value="{field_gb_msn}" name="msn" /><br />
      </sub><br />
    </td>
    <td>
      <div style="padding: 4px 4px 4px 4px; border-width: 1px 2px 2px 1px; background: #fbfbfb; border-color: #ebebeb; color: #000000; margin: 1em 0em 1em 0em; display: block; border-style: solid;">
      Message:<br />
      <textarea cols="55" rows="5" name="message">{field_gb_message}</textarea>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div style="padding: 4px 4px 4px 4px; border-width: 1px 2px 2px 1px; background: #fbfbfb; border-color: #ebebeb; color: #000000; margin: 1em 0em 1em 0em; display: block; border-style: solid;">
      Admin Comment: <input type="text" name="admincomment" value="{field_gb_admincomment}" size="60" />
      </div>
    </td>
  </tr>
</table>
<input type="submit" name="save" value="Save Changes" />
</form>


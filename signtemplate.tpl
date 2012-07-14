<form name="SimpliGuest" action="post.php" method="POST">
  <table style="width: 600px; border: 0px;">
    <tr>
      <td style="width: 200px;">
        Name: <span style="color: #FF0000">*</span>
      </td>
      <td>
        <input name="name" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td>
        Password: (admin only)
      </td>
      <td>
        <input name="password" type="password" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        Email: <span style="color: #FF0000">*</span>
      </td>
      <td>
        <input name="email" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        Website: 
      </td>
      <td>
        <input name="website" type="text" size="40" default="http://" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        ICQ: 
      </td>
      <td>
        <input name="icq" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        AIM: 
      </td>
      <td>
        <input name="aim" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        MSN: 
      </td>
      <td>
        <input name="msn" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        Yahoo/YIM: 
      </td>
      <td>
        <input name="yahoo" type="text" size="40" />
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        Emoticons:
      </td>
      <td>
        {emoticons}
      </td>
    </tr>
    <tr>
      <td style="width: 200px;">
        BBCode:
      </td>
      <td>
        [b]text[/b] - <b>text</b> , [i]text[/i] - <i>text</i> , [u]text[/u] - <u>text</u><br />&nbsp;<br />
        [url=http://www.example.com/]My Site[/url] - <a href="http://www.example.com/">My Site</a><br />&nbsp;<br />
        [email=me@nospam.com]Email Me[/email] - <a href="mailto:me@nospam.com">Email Me</a><br />&nbsp;<br />
        [code]text[/code] - <code>text</code><br />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <br />Message: <br />
        <textarea name="message" cols="55" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="Submit" value="Sign Guestbook" />
        <input type="reset" name="reset" value="Reset" />
      </td>
  </table>

/**
 * Created by Mihail Kornilov on 28.10.2014.
 */

$().ready(function() {
   $('.contact').on('click', function() {
       $(this).toggleClass('contact-selected');
       $('.text-input').focus();
   });
});

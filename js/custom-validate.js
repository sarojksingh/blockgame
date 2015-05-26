 $(document).ready(function () {
      /*  mouse hover effect on tournament page  */
      $('.back_imgdiv').hover(function () {
          if ($(this).children('.add_fund_btn').hasClass('show-element')) {
              $(this).children('.add_fund_btn').css('display', 'block');
          }
      },

      function () {
          $(this).children('.add_fund_btn').css('display', 'none');
      });

      /*  start Login form validation  */
      var validator = $("#form_login").validate({
          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },
          rules: {
              username: {
                  required: true,
                  minlength: 3,
                  maxlength: 15
              },
              password: {
                  required: true,
                  minlength: 6
              }
          },
          messages: {
              username: {

                  required: "Enter a username",
                  minlength: jQuery.format("Enter at least {0} characters"),
                  maxlength: jQuery.format("Maximum {0} characters allowed")
              },
              password: {
                  required: "Provide a password",
                  rangelength: jQuery.format("Enter at least {0} characters")
              }
          }


      });


  });
  /*  end Login form validation  */
  $(document).ready(function () {

      /*  start forgot password form validation  */
      var validator = $("#from_forgot_password").validate({
          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },
          rules: {
              email: {
                  required: true,
                  email: true
              }
          },
          messages: {
              email: {
                  required: "Enter email address",
                  email: "Invalid email address"

              }

          }


      });


  });
  /*  end forgot password form validation  */



  /*  start registration form validation  */

  $(document).ready(function () {
	   $.validator.addMethod("profileimageFormat", function (value) {
		var proimageval = $("#profile_img").val();
		if (proimageval == '') {
              return true;
          }
		if(!$.browser.msie) {
          var inputElement = document.querySelector("input[name='profile_img']");
		  var size = inputElement.files[0].size;
          var type = inputElement.files[0].type;
          var split = type.split('/');
		  return (split['0'] == 'image');
		} else {
			var arrayproimage =  proimageval.split('.')
			var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
			if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
				return true;
			} else {
				return false;
			}
		}
         
      }, "Invalid image type");

      $.validator.addMethod("imageFormat", function (value) {
		 var prize_picture1 = $("#prize_picture1").val();         
          if (prize_picture1 == '') {
              return true;
          }
		  if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='prize_picture1']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
			  return (split['0'] == 'image');
		  } else {
			var arrayproimage =  prize_picture1.split('.')
			var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
			if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
				return true;
			} else {
				return false;
			}
		  }
      }, "Invalid image type");

	  $.validator.addMethod("imageFormat2", function (value) {
		  var prize_picture2 = $("#prize_picture2").val();    
        
		  if (prize_picture2 == '') {
              return true;
          }
		   if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='prize_picture2']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
			  return (split['0'] == 'image'); 
		  } else {
				var arrayproimage =  prize_picture2.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					return true;
				} else {
					return false;
				}
		  }
      }, "Invalid image type");

	   $.validator.addMethod("imageFormat3", function (value) {		
          
          var prize_picture3 = $("#prize_picture3").val();    
        
		  if (prize_picture3 == '') {
              return true;
          }
		  if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='prize_picture3']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
			  return (split['0'] == 'image');
		  } else {
				var arrayproimage =  prize_picture3.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					return true;
				} else {
					return false;
				}
		  
		  }
      }, "Invalid image type");
	 
	  $.validator.addMethod("profileimageSize", function (value) {
          var proimageval = $("#profile_img").val();
		  if (proimageval == '') {
              return true;
          }		  
		  if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='profile_img']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
			  return (size < '2097152');
		  } else {
				var arrayproimage =  proimageval.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					return true;
				} else {
					return false;
				}
		  }
      }, "Image size should be less than 2M");

      $.validator.addMethod("imageSize", function (value) {
          var prize_picture1 = $("#prize_picture1").val();         
          if (prize_picture1 == '') {
              return true;
          }
		  if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='prize_picture1']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
			  if(size<'2097152' && split['0']=='image')
				{
					var img = $("#prize_picture1").val();
					$("#prize_picture1-name").html(img);
				}
			  return (size < '2097152');
		  } else {
				var arrayproimage =  proimageval.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					var img = $("#prize_picture1").val();
					$("#prize_picture1-name").html(img);
					return true;
				} else {
					return false;
				}
		  }
      }, "Image size should be less than 2M");
	  
	   $.validator.addMethod("imageSize2", function (value) {
		  var prize_picture2 = $("#prize_picture2").val();         
          if (prize_picture2 == '') {
              return true;
          }
          if(!$.browser.msie) {
			  var inputElement = document.querySelector("input[name='prize_picture2']");
			  var size = inputElement.files[0].size;
			  var type = inputElement.files[0].type;
			  var split = type.split('/');
				if(size<'2097152' && split['0']=='image')
				{
					var img = $("#prize_picture2").val();
					$("#prize_picture2-name").html(img);
				}
			  return (size < '2097152');
		  } else {
				var arrayproimage =  prize_picture2.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					var img = $("#prize_picture2").val();
					$("#prize_picture2-name").html(img);
					return true;
				} else {
					return false;
				}
		  
		  }

      }, "Image size should be less than 2M");

	   $.validator.addMethod("imageSize3", function (value) {
          var prize_picture3 = $("#prize_picture3").val();         
          if (prize_picture3 == '') {
              return true;
          }
		if(!$.browser.msie) {
          var inputElement = document.querySelector("input[name='prize_picture3']");
          var size = inputElement.files[0].size;
          var type = inputElement.files[0].type;
          var split = type.split('/');
		  if(size<'2097152' && split['0']=='image')
			{
				var img = $("#prize_picture3").val();
				$("#prize_picture3-name").html(img);
			}
          return (size < '2097152');
		} else {
			var arrayproimage =  prize_picture3.split('.')
				var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
				if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
					var img = $("#prize_picture3").val();
					$("#prize_picture3-name").html(img);
					return true;
				} else {
					return false;
				}
		  
		
		}

      }, "Image size should be less than 2M");

      $.validator.addMethod("noSpace", function (value, element) {
          return value.indexOf(" ") < 0 && value != "";
      }, "Space not allowed");

      var validator = $("#register_form").validate({
          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },
          rules: {
              name: "required",
              term_accept: "required",
              residence_confirm:"required",
              username: {
                  required: true,
                  minlength: 3,
                  maxlength: 15,
                  noSpace: true,
                  remote: {
                      url: "" + SITE_URL + "ajax/userValidation",
                      type: "POST"
                  }
              },
              password: {
                  required: true,
                  minlength: 6
              },
              confirm_password: {
                  required: true,
                  minlength: 6,
                  equalTo: "#password"
              },
              email: {
                  required: true,
                  email: true,
                  remote: {
                      url: "" + SITE_URL + "ajax/emailValidationRegister",
                      type: "POST"
                  }
              },
              confirm_email: {
                  required: true,
                  email: true,
                  equalTo: "#email"
              },

              profile_img: {
                  profileimageFormat: true,
                  profileimageSize: true
              }

          },
          messages: {

              name: "Enter name",
              term_accept: "Please select terms & conditions",
              residence_confirm:"Country confirmation is manadatory",
              username: {
                  required: "Enter username",
                  minlength: jQuery.format("Enter at least {0} characters"),
                  maxlength: jQuery.format("Enter at least {0} characters"),
                  remote: "Username already  exist."
              },
              password: {
                  required: "Provide a password",
                  rangelength: jQuery.format("Enter at least {0} characters")
              },
              email: {
                  required: "Enter email address",
                  email: "Invalid email address",
                  remote: "Email already  exist."

              },
              confirm_password: {
                  required: "Repeat your password",
                  minlength: jQuery.format("Enter at least {0} characters"),
                  equalTo: "Passwords do not match"
              },
              confirm_email: {
                  required: "Repeat your email",
                  email: "Invalid email address",
                  equalTo: "Email do not match"
              },
              profile_img: {
                  profileimageFormat: "Invalid image type",
                  profileimageSize: "Image sholud be less then 2MB"

              }
          }

      });


  });
  /*  end registration form validation  */

  /*  start edit form validation  */

  $(document).ready(function () {

      var id = $("#id").val();
      var validator = $("#edit-profile").validate({
          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },
          rules: {
              name: "required",
              username: {
                  required: true,
                  minlength: 3,
                  maxlength: 15
              },
              password: {
                  minlength: 6
              },
              confirm_password: {
                  minlength: 6,
                  equalTo: "#password"
              },
              email: {
                  required: true,
                  email: true,
                  remote: {
                      url: "" + SITE_URL + "ajax/emailValidation",
                      type: "POST",
                      data: {
                          id: id
                      }
                  }
              },
              confirm_email: {
                  required: true,
                  email: true,
                  equalTo: "#email"
              },
              profile_img: {
                  profileimageFormat: true,
                  profileimageSize: true
              }

          },
          messages: {

              name: "Enter name",

              username: {
                  required: "Enter username",
                  minlength: jQuery.format("Enter at least {0} characters"),
                  maxlength: jQuery.format("Enter at least {0} characters")
              },
              password: {
                  rangelength: jQuery.format("Enter at least {0} characters")
              },
              email: {
                  required: "Enter email address",
                  email: "Invalid email address",
                  remote: "Email already  exist."



              },
              confirm_password: {
                  required: "Repeat your password",
                  minlength: jQuery.format("Enter at least {0} characters"),
                  equalTo: "Passwords do not match"
              },
              confirm_password: {
                  minlength: jQuery.format("Enter at least {0} characters"),
                  equalTo: "Passwords do not match"
              },
              profile_img: {
                  profileimageFormat: "Invalid image type",
                  profileimageSize: "Image sholud be less then 2MB"

              }

          }

      });


  });
  /*  end edit form validation  */

  /*  start contact form validation  */


  $(document).ready(function () {
      var validator = $("#contact_form").validate({
          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },
          rules: {
              name: "required",
              message: "required",
              email: {
                  required: true,
                  email: true
              }
          },
          messages: {
              name: "Please enter name",
              email: {
                  required: "Enter email address",
                  email: "Invalid email address"

              },
              message: "Enter message",
          }


      });


  });
  /*  end contact form validation  */

  /*  start add tournament form validation  */



  $(document).ready(function () {

      $.validator.addMethod("timeformat", function (value) {
          return (value.match(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/));
      }, 'Enter a valid time');

      $.validator.addMethod("dateformat", function (value, element) {
          var day = $("#day").val();
          var month = $("#month").val();
          var year = $("#year").val();
          value = year + '-' + month + '-' + day;
		  if(day != '' || month != '' || year != '') {
			return value.match(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/);
		  } else {
			return true;
		  }
      }, "Enter a date in the format dd/mm/yyyy");

      $.validator.addMethod("currentdateformat", function (value, element) {
          var day = $("#day").val();
          var month = $("#month").val();
          var year = $("#year").val();
          value = year + '-' + month + '-' + day;
          var a = new Date();
          var msDateA = Date.UTC(a.getFullYear(), a.getMonth() + 1, a.getDate());
          var msDateB = Date.UTC(year, month, day);		 
          var mon = a.getMonth() + 1;
		   if(day != '' || month != '' || year != '') {
			return (parseFloat(msDateA) <= parseFloat(msDateB));
		   } else {
			  return true;
		   }
      }, "Invalid date");

	  $.validator.addMethod('timecrosscheck', function(value, element) {
		  var day = $("#day").val();
          var month = $("#month").val();
          var year = $("#year").val();
          var result_val = false;        
          var yearmonthdaytime = year + '-' + month + '-' + day + ' ' + value;
          $.ajax({
			 url: "" + SITE_URL + "ajax/validateEnterTime",
             type: "POST",
             async: false,
			 data: {							
					yearmonthdaytime:yearmonthdaytime
				  },
			 success: function(result) {
				if(result == true) {
					$('#time-errors span').remove();					
					$('#time').removeClass('error');
					result_val = result;
					return true; 
				}				
			 }
		  });
		  
		  if(result_val) {
			return true;  
			} else {
			 	
			}
		  		 
	  }, 'Entered time should be 15mins after current time');

      $("#month").bind("change keyup", function () {
          $("#form_addtournament").validate().element("#year");
      });
	  $("#year").bind("blur", function () {
          $("#form_addtournament").validate().element("#time");
      });

      $("#cost").bind("change", function () {
		 if(!isNaN($(this).val()) && $(this).val()>0) $(this).val(parseFloat($(this).val()).toFixed(2));
      });

      $("#day").bind("change keyup", function () {
          $("#form_addtournament").validate().element("#year");
      });

	  //Disable date time field in case of MINI Tournament
	  var formdetails = new Array('year', 'month', 'day', 'time');	
	  var mega_tour = new Array();	
	  var edit_day = $("#day").val();
	  var edit_month = $("#month").val();
	  var edit_year = $("#year").val();
	  var edit_time = $("#time").val();
				
	  $(".check_box").bind('click blur',function() {
		
			var tournamenttype = $(this).val();		
			
			if(tournamenttype == 2) {
				$("#no_of_tournaments").attr('disabled', false);
				$("#no_of_tournaments").css('background', 'none repeat scroll 0 0 transparent');
				$("#year").val('');
				$("#month").val('');
				$("#day").val('');
				$("#time").val('');
				$("#year").attr('disabled', true);
				$("#year").css('background', '#DDD');
				$("#month").attr('disabled', true);
				$("#month").css('background', '#DDD');
				$("#day").attr('disabled', true);
				$("#day").css('background', '#DDD');
				$("#time").attr('disabled', true);
				$("#time").css('background', '#DDD');
				$("#date_req").html("&nbsp;");
				$("#time_req").html("&nbsp;");
				$("#no_toru").html('*');
				$("#time-errors span").html('');
				$('#year-errors span').remove();
			} else {
				$("#no_of_tournaments").attr('disabled', true);
				$("#no_of_tournaments").css('background', '#DDD');
				if($("#year").val()){
					mega_tour['year'] = $("#year").val();
				}
				else {
					$("#year").val(edit_year);
				}

				if($("#month").val()) {
					mega_tour['month'] = $("#month").val();
				}
				else {
					$("#month").val(edit_month);
				}

				if($("#day").val()) {
					mega_tour['day'] = $("#day").val();
				}
				else {
					$("#day").val(edit_day);
				}

				if($("#time").val()) {
					mega_tour['time'] = $("#time").val();
				}
				else {
					$("#time").val(edit_time);
				}				
				
				$("#year").attr('disabled', false);
				$("#year").css('background', 'none repeat scroll 0 0 transparent');
				$("#month").attr('disabled', false);
				$("#month").css('background', 'none repeat scroll 0 0 transparent');
				$("#day").attr('disabled', false);
				$("#day").css('background', 'none repeat scroll 0 0 transparent');
				$("#time").attr('disabled', false);
				$("#time").css('background', 'none repeat scroll 0 0 transparent');
				$("#date_req").html("*");
				$("#time_req").html("*");
				$("#no_toru").html('&nbsp;');
				
			}
	  });


      var validator = $("#form_addtournament").validate({

          errorPlacement: function (error, element) {
              $("#" + element.attr("name") + "-errors").append(error);
              $("#" + element.attr("name") + "-errors").css('display', 'block');
          },

          rules: {
              //date year month day 

              //date year month day 
              prize_name: {
                  required: true,
                  maxlength: 255
              },			  
              tournament_name: {
					required: true,
					remote: {
                      url: "" + SITE_URL + "ajax/validateTournamentName",
                      type: "POST",
					  data: {							
							id: $("#id").val()
					  }
                  }
              },
			  current_status:"required",
              type: "required",
              prize_desc: "required",
              prize_picture1:{
                  required: function() {
						var action = $("#form_addtournament").attr('action');
						var arrayaction = action.split('/');
						var actionarraylastindex = arrayaction[arrayaction.length - 1];
						if(actionarraylastindex == 'updatetournament') {
							return false;
						}
						
				  },
                  imageFormat: true,
				  imageSize: true
              },
			  prize_picture2:  {
				  imageFormat2: true,
				  imageSize2: true
					  },
			  prize_picture3:  {
				  imageFormat3: true,
				  imageSize3: true
					  },
              time: {
                  required: true,
                  timeformat: true,
                  timecrosscheck: true				 
				  },
              year: {
                  required: true,
                  dateformat: true,
                  currentdateformat: true
              },
              cost: {
                  required: true,
                  number: true ,
                  min: 0.00
              },
			  no_of_tournaments: {
                  required: true,
                  digits: true,
                  min: 1
              },
          },
          messages: {
              prize_name: {
                  required: "Enter prize name",
                  maxlength: jQuery.format("Enter at least {0} characters")
              },
			  tournament_name: {
				 required: "Enter tournament name",
                 remote: "This tournament name is taken."
			  },
              type: "Select atleast one tournament",
              prize_desc: "Enter prize description",
			  current_status:"Please select current status",
              prize_picture1: {				  
				 required: "Select prize picture",
				 imageFormat: "Invalid image type"	  
			  },			
              time: {
                  required: "Enter time",
                  timeformat: "Enter correct format time",
                  timecrosscheck: 'Entered time should be 15mins after current time'
			  },
              cost: {
                  required: "Enter cost",
                  number: "Enter  valid number",
                  min: "Cost should be greater than or equal 0.00" 
              },
			no_of_tournaments: {
                  required: "Enter Number of Tournaments",
                  number: "Enter  valid number",
                  min: "No. of Tournaments should be greater than 1" 
              },
          }


      }); 
    

  });


  /*  end add tournament form validation  */

window.globalProvideData('slide', '{"title":"The 3 different types of goals are:","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"6gPqzOr8inA","lmsId":"Slide9","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":33,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"6hjFlhPRkGs","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"noteq","valuea":"5VjEIbRKAux.6JFGEokmH3j.$DragConnectData","typea":"property","valueb":"","typeb":"string"},{"kind":"compare","operator":"noteq","valuea":"5VjEIbRKAux.6ODd7szqUbX.$DragConnectData","typea":"property","valueb":"","typeb":"string"},{"kind":"compare","operator":"noteq","valuea":"5VjEIbRKAux.6PZtfoBRwQm.$DragConnectData","typea":"property","valueb":"","typeb":"string"}]}},"thenActions":[{"kind":"eval_interaction","id":"_this.6SXCSHIdyjy"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_605Th3zXokd.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_6hjFlhPRkGs"}]},"ReviewInt_5VjEIbRKAux":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6ZJpo42B8Sr"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6JFGEokmH3j"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.69wmr6n0nxp"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6ODd7szqUbX"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6CD7Dpfh2ie"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6PZtfoBRwQm"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6SXCSHIdyjy.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_5VjEIbRKAux","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001000101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5VjEIbRKAux"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5VjEIbRKAux"}]}]}]},"ReviewIntCorrectIncorrect_5VjEIbRKAux":{"kind":"actiongroup","actions":[{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.6ZJpo42B8Sr"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.6JFGEokmH3j"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.69wmr6n0nxp"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.6ODd7szqUbX"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.6CD7Dpfh2ie"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5VjEIbRKAux.6PZtfoBRwQm"},"enabled":{"type":"boolean","value":true}}]},"AnsweredInt_5VjEIbRKAux":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_5VjEIbRKAux"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001000101"}]}]},"DisableChoices_5VjEIbRKAux":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6ZJpo42B8Sr"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6JFGEokmH3j"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.69wmr6n0nxp"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6ODd7szqUbX"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6CD7Dpfh2ie"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5VjEIbRKAux.6PZtfoBRwQm"},"enabled":{"type":"boolean","value":false}}]},"5VjEIbRKAux_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6SXCSHIdyjy.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_5VjEIbRKAux"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6SXCSHIdyjy.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6SXCSHIdyjy.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_5VjEIbRKAux"}]}]}]}]},"SetLayout_pxabnsnfns01001000101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001000101"}]}]},"NavigationRestrictionNextSlide_6hjFlhPRkGs":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.5nnSyv28G8M"}}]},"NavigationRestrictionPreviousSlide_6hjFlhPRkGs":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001000101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_6hjFlhPRkGs","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5VjEIbRKAux","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_605Th3zXokd","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_605Th3zXokd","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5VjEIbRKAux","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_5VjEIbRKAux"}],"elseActions":[{"kind":"exe_actiongroup","id":"5VjEIbRKAux_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5VjEIbRKAux","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_5VjEIbRKAux","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_6hjFlhPRkGs"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_6hjFlhPRkGs"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_6hjFlhPRkGs","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":5000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6D84Y9ajZSG"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6dn7thhKrVT"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6iPuodFxDdZ"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6iPuodFxDdZ.6Q1okDqbjDg"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6iPuodFxDdZ.6jFFqXnM74c"}}]},{"kind":"ontimelinetick","time":750,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6Q78fkdPjcO"}}]},{"kind":"ontimelinetick","time":1750,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6VuEUE9aAUj"}}]},{"kind":"ontimelinetick","time":2000,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.6ZJpo42B8Sr"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.6JFGEokmH3j"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.69wmr6n0nxp"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.6ODd7szqUbX"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.6CD7Dpfh2ie"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VjEIbRKAux.6PZtfoBRwQm"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5VjEIbRKAux"}}]},{"kind":"ontimelinetick","time":2500,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6T3mvwrgLlO"}}]},{"kind":"ontimelinetick","time":4250,"actions":[{"kind":"hide","transition":"custom","animationId":"Exit","reverse":false,"objRef":{"type":"string","value":"6VuEUE9aAUj"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":34,"id":"01","url":"story_content/6ejPLK0xwhe_80_DX1998_DY1998.swf","type":"normal","altText":"lens_flare.png","width":1920,"height":1078,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":1,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":109}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"6D84Y9ajZSG"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":3,"id":"01","url":"story_content/6KMhsnvrKAZ_X_80_DX1998_DY1998.swf","type":"normal","altText":"blue-lens_flare.png","width":1920,"height":1078,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":1,"yPos":0,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"blue-lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":110}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"6dn7thhKrVT"},{"kind":"objgroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":16,"id":"01","url":"story_content/6AVPGlXlEOY_80_DX1998_DY1998.swf","type":"normal","altText":"objectives.png","width":1920,"height":301,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":8,"yPos":8,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":78.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":157,"altText":"objectives.png","pngfb":false,"pr":{"l":"Lib","i":3}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":157,"strokewidth":0}},"width":999,"height":157,"resume":true,"useHandCursor":true,"id":"6Q1okDqbjDg"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6jFFqXnM74c_1956302744","id":"01","linkId":"txt__default_6jFFqXnM74c","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":545,"bottom":50,"pngfb":false,"pr":{"l":"Lib","i":112}}}],"shapemaskId":"","xPos":58,"yPos":57,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":450,"rotateYPos":28,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":900,"bottom":56,"altText":"The 3 different types of goals are:","pngfb":false,"pr":{"l":"Lib","i":111}},"html5data":{"xPos":-1,"yPos":-1,"width":901,"height":57,"strokewidth":0}},"width":900,"height":56,"resume":true,"useHandCursor":true,"id":"6jFFqXnM74c"}],"accType":"text","altText":"Group\\r\\n 1","shapemaskId":"","xPos":-8,"yPos":-8,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":507.5,"rotateYPos":86.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-1012","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":1015,"height":173,"resume":true,"useHandCursor":true,"id":"6iPuodFxDdZ"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":35,"id":"01","url":"story_content/5fynv90Qe1K_X_80_P_125_0_1474_824_DX1920_DY1920.swf","type":"normal","altText":"target.png","width":1474,"height":825,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":1,"yPos":25,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":480,"rotateYPos":268.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":960,"bottom":537,"altText":"target.png","pngfb":false,"pr":{"l":"Lib","i":113}},"html5data":{"xPos":0,"yPos":0,"width":960,"height":537,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"mask":{"type":"randombars","settings":[{"kind":"setting","name":"direction","value":"horizontal"}],"duration":750,"easing":"linear","easingdir":"easeinout"}}]}],"width":960,"height":537,"resume":true,"useHandCursor":true,"id":"6Q78fkdPjcO"},{"kind":"scrollarea","contentwidth":899,"contentheight":256,"objects":[{"kind":"shufflegroup","objects":[{"kind":"dragitem","style":"matching","connectdata":"choices.choice_5t8PobYmYP3","reviewdata":3,"shapemaskId":"","xPos":480,"yPos":171,"tabIndex":15,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6CD7Dpfh2ie_-1307389946","type":"vectortext","altText":"Concerned with how athletes perform particular skills or execute strategies","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":371,"bottom":60,"pngfb":false,"pr":{"l":"Lib","i":115}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"6CD7Dpfh2ie"},{"kind":"dragitem","style":"matching","connectdata":"choices.choice_6eOW944hoTZ","reviewdata":2,"shapemaskId":"","xPos":480,"yPos":87,"tabIndex":12,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_69wmr6n0nxp_617986360","type":"vectortext","altText":"Athletes actual performance in relation to their own standard of excellence","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":403,"bottom":60,"pngfb":false,"pr":{"l":"Lib","i":116}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"69wmr6n0nxp"},{"kind":"dragitem","style":"matching","connectdata":"choices.choice_5YPQLg0AeaT","reviewdata":1,"shapemaskId":"","xPos":480,"yPos":4,"tabIndex":9,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6ZJpo42B8Sr_2010476806","type":"vectortext","altText":"The desired results of a competition","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":346,"bottom":47,"pngfb":false,"pr":{"l":"Lib","i":117}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"6ZJpo42B8Sr"}],"shuffle":true,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":true,"useHandCursor":true,"id":""},{"kind":"droparea","style":"matching","reviewdata":3,"shapemaskId":"","xPos":22,"yPos":171,"tabIndex":14,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6PZtfoBRwQm_1508897273","type":"vectortext","altText":"Process Goals:","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":164,"bottom":49,"pngfb":false,"pr":{"l":"Lib","i":118}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"6PZtfoBRwQm"},{"kind":"droparea","style":"matching","reviewdata":2,"shapemaskId":"","xPos":22,"yPos":87,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6ODd7szqUbX_-622403009","type":"vectortext","altText":"Performance Goals:","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":218,"bottom":49,"pngfb":false,"pr":{"l":"Lib","i":119}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"6ODd7szqUbX"},{"kind":"droparea","style":"matching","reviewdata":1,"shapemaskId":"","xPos":22,"yPos":4,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":221,"rotateYPos":34.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6JFGEokmH3j_-806801685","type":"vectortext","altText":"Outcome Goals:","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":181,"bottom":49,"pngfb":false,"pr":{"l":"Lib","i":120}}},"html5data":{"xPos":-1,"yPos":-1,"width":443,"height":70,"strokewidth":0}},"width":442,"height":69,"resume":true,"useHandCursor":true,"id":"6JFGEokmH3j"}],"shapemaskId":"","xPos":22,"yPos":191,"tabIndex":6,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":483.5,"rotateYPos":163,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":22,"yPos":191,"width":966,"height":326,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":966,"height":326,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":967,"bottom":327,"altText":"Matching Drag and Drop","pngfb":false,"pr":{"l":"Lib","i":114}}},"id":"5VjEIbRKAux"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6T3mvwrgLlO_-389418337","id":"01","linkId":"txt__default_6T3mvwrgLlO","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":398,"bottom":64,"pngfb":false,"pr":{"l":"Lib","i":122}}}],"shapemaskId":"","xPos":557,"yPos":466,"tabIndex":17,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":203.5,"rotateYPos":35,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":407,"bottom":70,"altText":"Click & drag the correct description to the appropriate action step","pngfb":false,"pr":{"l":"Lib","i":121}},"html5data":{"xPos":-1,"yPos":-1,"width":408,"height":71,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":1000,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":1000,"mask":{"type":"wipe","settings":[{"kind":"setting","name":"direction","value":"fromright"}],"duration":1000,"easing":"linear","easingdir":"easeinout"}}]}],"width":407,"height":70,"resume":true,"useHandCursor":true,"id":"6T3mvwrgLlO"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":36,"id":"01","url":"story_content/5aTJd2PblL9_80_DX186_DY186.swf","type":"normal","altText":"finger.png","width":186,"height":186,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":667,"yPos":458,"tabIndex":16,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":46.5,"rotateYPos":46.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":93,"bottom":93,"altText":"finger.png","pngfb":false,"pr":{"l":"Lib","i":123}},"html5data":{"xPos":0,"yPos":0,"width":93,"height":93,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":2250,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":2250,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"809.5","y":"456.5","dx":"0","dy":"0"},"anchorb":{"x":"446.6914","y":"458.5815","dx":"0","dy":"0"}}],"duration":2250,"easing":"cubic","easingdir":"easeinout"}}]},{"kind":"animation","id":"Exit","duration":750,"hidetextatend":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"100","dstart":"0","end":"0","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easeout"}}]},{"kind":"animation","id":"63TIPxFzfz3","duration":2250,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":2250,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"809.5","y":"456.5","dx":"0","dy":"0"},"anchorb":{"x":"446.6914","y":"458.5815","dx":"0","dy":"0"}}],"duration":2250,"easing":"cubic","easingdir":"easeinout"}}]}],"width":93,"height":93,"resume":true,"useHandCursor":true,"id":"6VuEUE9aAUj","events":[{"kind":"ontransitionin","actions":[]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5VjEIbRKAux_CorrectReview","id":"01","linkId":"5VjEIbRKAux_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":34}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":18,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":8,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":33}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"5VjEIbRKAux_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5VjEIbRKAux_IncorrectReview","id":"01","linkId":"5VjEIbRKAux_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":36}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":19,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":9,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":35}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"5VjEIbRKAux_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"6gPqzOr8inA","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');
window.globalProvideData('slide', '{"title":"When an athlete is lacking confidence, a coach should be very deliberate about offering verbal                       .","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"5sYS5Pmb0xo","lmsId":"Slide7","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":29,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"60DhL2f48DA","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"noteq","valuea":"68grVRx3wES.$DragConnectData","typea":"property","valueb":"","typeb":"string"}},"thenActions":[{"kind":"eval_interaction","id":"_this.6nhwhDtJiJa"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_6EmUXPTIvkg.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_60DhL2f48DA"}]},"ReviewInt_6gXmAuxTcgR":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6Q02fh5PGDy"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6rdrC0F4ufU"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.5yWHwSlZoRz"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6IBrOR7x5mF"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68grVRx3wES"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6nhwhDtJiJa.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_6gXmAuxTcgR","typea":"var","valueb":"6KQ5daPkfWz","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001010101"}]}]},"ReviewIntCorrectIncorrect_6gXmAuxTcgR":{"kind":"actiongroup","actions":[{"kind":"set_review","objRef":{"type":"string","value":"6gXmAuxTcgR.6Q02fh5PGDy"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"6gXmAuxTcgR.6rdrC0F4ufU"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"6gXmAuxTcgR.5yWHwSlZoRz"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"6gXmAuxTcgR.6IBrOR7x5mF"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"68grVRx3wES"},"enabled":{"type":"boolean","value":true}}]},"AnsweredInt_6gXmAuxTcgR":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_6gXmAuxTcgR"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"DisableChoices_6gXmAuxTcgR":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6Q02fh5PGDy"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6rdrC0F4ufU"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.5yWHwSlZoRz"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6gXmAuxTcgR.6IBrOR7x5mF"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68grVRx3wES"},"enabled":{"type":"boolean","value":false}}]},"6gXmAuxTcgR_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6nhwhDtJiJa.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6KQ5daPkfWz.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_6gXmAuxTcgR"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6nhwhDtJiJa.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6nhwhDtJiJa.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_6gXmAuxTcgR"}]}]}]}]},"SetLayout_pxabnsnfns01001010101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"NavigationRestrictionNextSlide_60DhL2f48DA":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.6UVGBJ1eqTe"}}]},"NavigationRestrictionPreviousSlide_60DhL2f48DA":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001010101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_60DhL2f48DA","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6gXmAuxTcgR","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6EmUXPTIvkg","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6EmUXPTIvkg","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6gXmAuxTcgR","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_6gXmAuxTcgR"}],"elseActions":[{"kind":"exe_actiongroup","id":"6gXmAuxTcgR_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6gXmAuxTcgR","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_6gXmAuxTcgR","typea":"var","valueb":"6KQ5daPkfWz","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6KQ5daPkfWz"},"completed_slide_ref":{"type":"string","value":"_player.5ZAydOZjqPs.6hp1w4c7eO6"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_60DhL2f48DA"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_60DhL2f48DA"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_60DhL2f48DA","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":4500,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6H5JDcLLeo6"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AHYIbuEHRG"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5XyIEYbvzRu"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR.6IBrOR7x5mF"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR.5yWHwSlZoRz"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR.6rdrC0F4ufU"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6gXmAuxTcgR.6Q02fh5PGDy"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68grVRx3wES"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6GyPS1bYuvQ"}}]},{"kind":"ontimelinetick","time":1000,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"69uuA3bdJd2"}}]},{"kind":"ontimelinetick","time":1750,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6TZ3Qyv05do"}}]},{"kind":"ontimelinetick","time":2000,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5uSdt1qdVww"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":17,"id":"01","url":"story_content/5xSnN776U3W_80_DX1998_DY1998.swf","type":"normal","altText":"lens_flare.png","width":1920,"height":1078,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":1,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":43}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"6H5JDcLLeo6"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":18,"id":"01","url":"story_content/5fWLTt4RQM7_X_80_DX1124_DY1124.swf","type":"normal","altText":"blue stripe.png","width":581,"height":1080,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":613,"yPos":0,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":151.5,"rotateYPos":281,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":303,"bottom":562,"altText":"blue stripe.png","pngfb":false,"pr":{"l":"Lib","i":44}},"html5data":{"xPos":0,"yPos":0,"width":303,"height":562,"strokewidth":0}},"width":303,"height":562,"resume":true,"useHandCursor":true,"id":"6AHYIbuEHRG"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":19,"id":"01","url":"story_content/5jRVn7dj7dh_80_P_532_58_895_656_DX1706_DY1706.swf","type":"normal","altText":"chalktalk.png","width":896,"height":656,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":103,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":312.5,"rotateYPos":229,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":625,"bottom":458,"altText":"chalktalk.png","pngfb":false,"pr":{"l":"Lib","i":45}},"html5data":{"xPos":0,"yPos":0,"width":625,"height":458,"strokewidth":0}},"width":625,"height":458,"resume":true,"useHandCursor":true,"id":"5XyIEYbvzRu"},{"kind":"scrollarea","contentwidth":208,"contentheight":215,"objects":[{"kind":"shufflegroup","objects":[{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_6IBrOR7x5mF","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":180,"tabIndex":7,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":104,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6IBrOR7x5mF_-519892407","type":"vectortext","altText":"operants","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":106,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":65}}},"html5data":{"xPos":-1,"yPos":-1,"width":209,"height":36,"strokewidth":0}},"width":208,"height":35,"resume":true,"useHandCursor":true,"id":"6IBrOR7x5mF"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_5yWHwSlZoRz","reviewdata":1,"shapemaskId":"","xPos":21,"yPos":122,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":104,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5yWHwSlZoRz_1215660135","type":"vectortext","altText":"encouragement","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":178,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":66}}},"html5data":{"xPos":-1,"yPos":-1,"width":209,"height":36,"strokewidth":0}},"width":208,"height":35,"resume":true,"useHandCursor":true,"id":"5yWHwSlZoRz"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_6rdrC0F4ufU","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":64,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":104,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6rdrC0F4ufU_1149895564","type":"vectortext","altText":"correction","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":119,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":67}}},"html5data":{"xPos":-1,"yPos":-1,"width":209,"height":36,"strokewidth":0}},"width":208,"height":35,"resume":true,"useHandCursor":true,"id":"6rdrC0F4ufU"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_6Q02fh5PGDy","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":5,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":104,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":4,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6Q02fh5PGDy_-645939963","type":"vectortext","altText":"criticism","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":97,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":68}}},"html5data":{"xPos":-1,"yPos":-1,"width":209,"height":36,"strokewidth":0}},"width":208,"height":35,"resume":true,"useHandCursor":true,"id":"6Q02fh5PGDy"}],"shuffle":false,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":false,"useHandCursor":true,"id":""}],"shapemaskId":"","xPos":622,"yPos":32,"tabIndex":3,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":139,"rotateYPos":151.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":622,"yPos":32,"width":277,"height":303,"strokewidth":0}},"width":277,"height":303,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":278,"bottom":304,"altText":"Word Bank","pngfb":false,"pr":{"l":"Lib","i":64}}},"id":"6gXmAuxTcgR"},{"kind":"droparea","style":"wordbank","reviewdata":0,"shapemaskId":"","xPos":188,"yPos":176,"tabIndex":9,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":104,"rotateYPos":18.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":5,"scrolling":true,"shuffleLock":false,"width":208,"height":37,"resume":true,"useHandCursor":true,"background":{"type":"swf","imagedata":{"assetId":30,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"68grVRx3wES"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6GyPS1bYuvQ_-135509450","id":"01","linkId":"txt__default_6GyPS1bYuvQ","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":507,"bottom":186,"pngfb":false,"pr":{"l":"Lib","i":70}}}],"shapemaskId":"","xPos":60,"yPos":31,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":264.5,"rotateYPos":96,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":529,"bottom":192,"altText":"When an athlete is lacking confidence, a coach should be very deliberate about offering verbal                       .","pngfb":false,"pr":{"l":"Lib","i":69}},"html5data":{"xPos":-1,"yPos":-1,"width":530,"height":193,"strokewidth":0}},"width":529,"height":192,"resume":true,"useHandCursor":true,"id":"6GyPS1bYuvQ"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":24,"id":"01","url":"story_content/5W0ui6QY7sY_80_DX288_DY288.swf","type":"normal","altText":"finger.png","width":288,"height":288,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":686,"yPos":347,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":72,"rotateYPos":72,"scaleX":100,"scaleY":100,"alpha":100,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":144,"bottom":144,"altText":"finger.png","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":0,"yPos":0,"width":144,"height":144,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":2000,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":2000,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"686","y":"347","dx":"0","dy":"0"},"anchorb":{"x":"27.6667","y":"347","dx":"0","dy":"0"}}],"duration":2000,"easing":"cubic","easingdir":"easeinout"}}]},{"kind":"animation","id":"6F8uQ4o3V15","duration":2000,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":2000,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"686","y":"347","dx":"0","dy":"0"},"anchorb":{"x":"27.6667","y":"347","dx":"0","dy":"0"}}],"duration":2000,"easing":"cubic","easingdir":"easeinout"}}]}],"width":144,"height":144,"resume":true,"useHandCursor":true,"id":"69uuA3bdJd2","events":[{"kind":"ontransitionin","actions":[]}]},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":25,"id":"01","url":"story_content/63vZsHRilfo_80_DX342_DY342.swf","type":"normal","altText":"forward_arrow-512.png","width":342,"height":220,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":622,"yPos":331,"tabIndex":10,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":85.5,"rotateYPos":55,"scaleX":100,"scaleY":100,"alpha":100,"depth":8,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":171,"bottom":110,"altText":"forward_arrow-512.png","pngfb":false,"pr":{"l":"Lib","i":52}},"html5data":{"xPos":0,"yPos":0,"width":171,"height":110,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":171,"height":110,"resume":true,"useHandCursor":true,"id":"5uSdt1qdVww"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6TZ3Qyv05do_570397918","id":"01","linkId":"txt__default_6TZ3Qyv05do","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":419,"bottom":74,"pngfb":false,"pr":{"l":"Lib","i":54}}}],"shapemaskId":"","xPos":156,"yPos":357,"tabIndex":12,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":222,"rotateYPos":40,"scaleX":100,"scaleY":100,"alpha":100,"depth":9,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":444,"bottom":80,"altText":"Click & drag the correct answer to complete the sentence above.","pngfb":false,"pr":{"l":"Lib","i":53}},"html5data":{"xPos":-1,"yPos":-1,"width":445,"height":81,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"mask":{"type":"wipe","settings":[{"kind":"setting","name":"direction","value":"fromright"}],"duration":750,"easing":"linear","easingdir":"easeinout"}}]}],"width":444,"height":80,"resume":true,"useHandCursor":true,"id":"6TZ3Qyv05do"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6gXmAuxTcgR_CorrectReview","id":"01","linkId":"6gXmAuxTcgR_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":40}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":13,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":10,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":39}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"6gXmAuxTcgR_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6gXmAuxTcgR_IncorrectReview","id":"01","linkId":"6gXmAuxTcgR_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":42}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":14,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":11,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":41}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"6gXmAuxTcgR_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"5sYS5Pmb0xo","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');
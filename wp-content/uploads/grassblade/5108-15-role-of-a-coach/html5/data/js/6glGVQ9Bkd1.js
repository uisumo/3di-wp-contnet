window.globalProvideData('slide', '{"title":"Review the “Mindset Graphic” linked above, then answer the following questions.","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"61papgTo14k","lmsId":"Slide9","width":720,"height":405,"resume":true,"background":{"type":"swf","imagedata":{"assetId":0,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"6glGVQ9Bkd1","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"noteq","valuea":"68L3VRuvaub.5knpN9HGOai.$SelectedItemData","typea":"property","valueb":"","typeb":"string"},{"kind":"compare","operator":"noteq","valuea":"68L3VRuvaub.5jVbrIkSsxg.$SelectedItemData","typea":"property","valueb":"","typeb":"string"}]}},"thenActions":[{"kind":"eval_interaction","id":"_this.6Ghv7pFmbSe"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_6ObrqYz0hD8.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_6glGVQ9Bkd1"}]},"ReviewInt_68L3VRuvaub":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.68HNon99qRl"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.6gKc6OKmQ3U"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.5knpN9HGOai"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.5jVbrIkSsxg"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6Ghv7pFmbSe.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_68L3VRuvaub","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001010101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_68L3VRuvaub"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_68L3VRuvaub"}]}]}]},"ReviewIntCorrectIncorrect_68L3VRuvaub":{"kind":"actiongroup","actions":[{"kind":"set_review","objRef":{"type":"string","value":"68L3VRuvaub.68HNon99qRl"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"68L3VRuvaub.6gKc6OKmQ3U"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"68L3VRuvaub.5knpN9HGOai"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"68L3VRuvaub.5jVbrIkSsxg"},"enabled":{"type":"boolean","value":true}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"noteq","valuea":"choices.choice_5knpN9HGOai","typea":"string","valueb":"68L3VRuvaub.5knpN9HGOai.$SelectedItemData","typeb":"property"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub.5knpN9HGOai_ReviewShape"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"noteq","valuea":"choices.choice_5jVbrIkSsxg","typea":"string","valueb":"68L3VRuvaub.5jVbrIkSsxg.$SelectedItemData","typeb":"property"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub.5jVbrIkSsxg_ReviewShape"}}]}]},"AnsweredInt_68L3VRuvaub":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_68L3VRuvaub"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"DisableChoices_68L3VRuvaub":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.68HNon99qRl"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.6gKc6OKmQ3U"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.5knpN9HGOai"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"68L3VRuvaub.5jVbrIkSsxg"},"enabled":{"type":"boolean","value":false}}]},"68L3VRuvaub_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6Ghv7pFmbSe.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_68L3VRuvaub"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6Ghv7pFmbSe.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6Ghv7pFmbSe.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_68L3VRuvaub"}]}]}]}]},"SetLayout_pxabnsnfns01001010101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"NavigationRestrictionNextSlide_6glGVQ9Bkd1":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.5nnSyv28G8M"}}]},"NavigationRestrictionPreviousSlide_6glGVQ9Bkd1":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001010101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_6glGVQ9Bkd1","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68L3VRuvaub","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6ObrqYz0hD8","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6ObrqYz0hD8","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68L3VRuvaub","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_68L3VRuvaub"}],"elseActions":[{"kind":"exe_actiongroup","id":"68L3VRuvaub_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68L3VRuvaub","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_68L3VRuvaub","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_6glGVQ9Bkd1"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_6glGVQ9Bkd1"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_6glGVQ9Bkd1","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":4500,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6IiwB1hIY7P"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6bGSQ5LZZcX"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5VwymiXJVSU"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VwymiXJVSU.6DtChRk3YpV"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5VwymiXJVSU.6PqVOOhoG1s"}}]},{"kind":"ontimelinetick","time":500,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6i4FfiBMqLQ"}}]},{"kind":"ontimelinetick","time":1250,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"68L3VRuvaub"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"68L3VRuvaub.6gKc6OKmQ3U"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub.5jVbrIkSsxg"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"68L3VRuvaub.68HNon99qRl"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68L3VRuvaub.5knpN9HGOai"}}]},{"kind":"ontimelinetick","time":2000,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6F7rQX7xyZo"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":16,"id":"01","url":"story_content/6ejPLK0xwhe_X_80_DX1856_DY1856.swf","type":"normal","altText":"lens_flare.png","width":1856,"height":1042,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":202,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":404,"altText":"lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":80}},"html5data":{"xPos":0,"yPos":0,"width":720,"height":404,"strokewidth":0}},"width":720,"height":404,"resume":true,"useHandCursor":true,"id":"6IiwB1hIY7P"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":1,"id":"01","url":"story_content/6GKh7fy37ay_80_DX1440_DY1440.swf","type":"normal","altText":"lens_flare-middle.png","width":1440,"height":810,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":202.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":405,"altText":"lens_flare-middle.png","pngfb":false,"pr":{"l":"Lib","i":81}},"html5data":{"xPos":0,"yPos":0,"width":720,"height":405,"strokewidth":0}},"width":720,"height":405,"resume":true,"useHandCursor":true,"id":"6bGSQ5LZZcX"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":26,"id":"01","url":"story_content/6XRANf5dinn_80_DX894_DY894.swf","type":"normal","altText":"runner.png","width":894,"height":583,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":273,"yPos":113,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":223.5,"rotateYPos":146,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":447,"bottom":292,"altText":"runner.png","pngfb":false,"pr":{"l":"Lib","i":82}},"html5data":{"xPos":0,"yPos":0,"width":447,"height":292,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"mask":{"type":"randombars","settings":[{"kind":"setting","name":"direction","value":"horizontal"}],"duration":750,"easing":"linear","easingdir":"easeinout"}}]}],"width":447,"height":292,"resume":true,"useHandCursor":true,"id":"6F7rQX7xyZo"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":0,"yPos":162,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":60,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":120,"altText":"Rectangle 1","pngfb":false,"pr":{"l":"Lib","i":83}},"html5data":{"xPos":-1,"yPos":-1,"width":719,"height":121,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-725","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":720,"height":120,"resume":true,"useHandCursor":true,"id":"6i4FfiBMqLQ"},{"kind":"scrollarea","contentwidth":680,"contentheight":122,"objects":[{"kind":"shufflegroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"6gKc6OKmQ3U_-315465713","id":"01","linkId":"txt__default_6gKc6OKmQ3U","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":392,"bottom":41,"pngfb":false,"pr":{"l":"Lib","i":86}}}],"shapemaskId":"","xPos":0,"yPos":61,"tabIndex":9,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":340,"rotateYPos":30.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":680,"bottom":61,"altText":"Praising effort, strategies and process helps foster:","pngfb":false,"pr":{"l":"Lib","i":85}},"html5data":{"xPos":-1,"yPos":-1,"width":681,"height":62,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-709","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":680,"height":61,"resume":true,"useHandCursor":true,"id":"6gKc6OKmQ3U"},{"kind":"droplist","shuffle":true,"reviewwidth":115,"reviewindex":1,"shapemaskId":"","xPos":430,"yPos":80,"tabIndex":10,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":115,"rotateYPos":11,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"item_hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xAEE9FF","alpha":100,"stop":0}]}},{"kind":"color","name":"button_hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xD5F3FF","alpha":100,"stop":0}]}},{"kind":"color","name":"review_text","fill":{"type":"linear","rotation":0,"colors":[{"kind":"color","rgb":"0x000000","alpha":100,"stop":0}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt2_5jVbrIkSsxg","type":"vectortext","altText":"--Select--","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":69,"bottom":21,"pngfb":false,"pr":{"l":"Lib","i":87}}},"itemlist":[{"kind":"item","itemdata":"choices.choice_68HNon99qRl","hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5knpN9HGOai_477062892","type":"vectortext","altText":"a fixed mindset","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":126,"bottom":22,"pngfb":false,"pr":{"l":"Lib","i":88}}}},{"kind":"item","itemdata":"choices.choice_6gKc6OKmQ3U","hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5jVbrIkSsxg_1052980128","type":"vectortext","altText":"a growth mindset","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":142,"bottom":22,"pngfb":false,"pr":{"l":"Lib","i":89}}}}]},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-689","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":230,"height":22,"resume":true,"useHandCursor":true,"id":"5jVbrIkSsxg"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"68HNon99qRl_1583974310","id":"01","linkId":"txt__default_68HNon99qRl","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":420,"bottom":41,"pngfb":false,"pr":{"l":"Lib","i":90}}}],"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":7,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":340,"rotateYPos":30.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":680,"bottom":61,"altText":"Praising talent, intelligence and outcomes helps foster:","pngfb":false,"pr":{"l":"Lib","i":85}},"html5data":{"xPos":-1,"yPos":-1,"width":681,"height":62,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-709","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":680,"height":61,"resume":true,"useHandCursor":true,"id":"68HNon99qRl"},{"kind":"droplist","shuffle":true,"reviewwidth":115,"reviewindex":0,"shapemaskId":"","xPos":430,"yPos":20,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":115,"rotateYPos":11,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":4,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"item_hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xAEE9FF","alpha":100,"stop":0}]}},{"kind":"color","name":"button_hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xD5F3FF","alpha":100,"stop":0}]}},{"kind":"color","name":"review_text","fill":{"type":"linear","rotation":0,"colors":[{"kind":"color","rgb":"0x000000","alpha":100,"stop":0}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt2_5jVbrIkSsxg","type":"vectortext","altText":"--Select--","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":69,"bottom":21,"pngfb":false,"pr":{"l":"Lib","i":87}}},"itemlist":[{"kind":"item","itemdata":"choices.choice_68HNon99qRl","hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5knpN9HGOai_477062892","type":"vectortext","altText":"a fixed mindset","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":126,"bottom":22,"pngfb":false,"pr":{"l":"Lib","i":88}}}},{"kind":"item","itemdata":"choices.choice_6gKc6OKmQ3U","hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5jVbrIkSsxg_1052980128","type":"vectortext","altText":"a growth mindset","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":142,"bottom":22,"pngfb":false,"pr":{"l":"Lib","i":89}}}}]},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-689","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":230,"height":22,"resume":true,"useHandCursor":true,"id":"5knpN9HGOai"}],"shuffle":false,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":false,"useHandCursor":true,"id":""},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5knpN9HGOai_ReviewShape","id":"01","linkId":"5knpN9HGOai_ReviewShape","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":115,"bottom":22,"pngfb":false,"pr":{"l":"Lib","i":92}}}],"shapemaskId":"","xPos":555,"yPos":19,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":57.5,"rotateYPos":11,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":115,"bottom":22,"altText":"a fixed mindset","pngfb":false,"pr":{"l":"Lib","i":91}},"html5data":{"xPos":0,"yPos":0,"width":115,"height":22,"strokewidth":0}},"width":115,"height":22,"resume":false,"useHandCursor":true,"id":"5knpN9HGOai_ReviewShape"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5jVbrIkSsxg_ReviewShape","id":"01","linkId":"5jVbrIkSsxg_ReviewShape","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":105,"bottom":20,"pngfb":false,"pr":{"l":"Lib","i":93}}}],"shapemaskId":"","xPos":555,"yPos":80,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":57.5,"rotateYPos":11,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":105,"bottom":20,"altText":"a growth mindset","pngfb":false,"pr":{"l":"Lib","i":91}},"html5data":{"xPos":0,"yPos":0,"width":105,"height":20,"strokewidth":0}},"width":115,"height":22,"resume":false,"useHandCursor":true,"id":"5jVbrIkSsxg_ReviewShape"}],"shapemaskId":"","xPos":24,"yPos":160,"tabIndex":6,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":340,"rotateYPos":88,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":24,"yPos":160,"width":680,"height":176,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-709","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":680,"height":176,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":680,"bottom":176,"altText":"Matching Drop-down","pngfb":false,"pr":{"l":"Lib","i":84}}},"id":"68L3VRuvaub"},{"kind":"objgroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":19,"id":"01","url":"story_content/6AVPGlXlEOY_80_DX1440_DY1440.swf","type":"normal","altText":"objectives.png","width":1440,"height":226,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":8,"yPos":8,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":56.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":113,"altText":"objectives.png","pngfb":false,"pr":{"l":"Lib","i":3}},"html5data":{"xPos":0,"yPos":0,"width":720,"height":113,"strokewidth":0}},"width":720,"height":113,"resume":true,"useHandCursor":true,"id":"6DtChRk3YpV"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6PqVOOhoG1s_-1388019870","id":"01","linkId":"txt__default_6PqVOOhoG1s","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":575,"bottom":69,"pngfb":false,"pr":{"l":"Lib","i":95}}}],"shapemaskId":"","xPos":44,"yPos":25,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":324,"rotateYPos":37,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":648,"bottom":74,"altText":"Review the “Mindset Graphic” linked above, then answer the following questions.","pngfb":false,"pr":{"l":"Lib","i":94}},"html5data":{"xPos":-1,"yPos":-1,"width":649,"height":75,"strokewidth":0}},"width":648,"height":74,"resume":true,"useHandCursor":true,"id":"6PqVOOhoG1s"}],"accType":"text","altText":"Group\\r\\n 1","shapemaskId":"","xPos":-8,"yPos":-8,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":368,"rotateYPos":64.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":6,"scrolling":true,"shuffleLock":false,"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-733","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":736,"height":129,"resume":true,"useHandCursor":true,"id":"5VwymiXJVSU"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"68L3VRuvaub_CorrectReview","id":"01","linkId":"68L3VRuvaub_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":400,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":27}}}],"shapemaskId":"","xPos":0,"yPos":365,"tabIndex":12,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":720,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":26}},"html5data":{"xPos":1,"yPos":1,"width":717,"height":37,"strokewidth":2}},"width":720,"height":40,"resume":false,"useHandCursor":true,"id":"68L3VRuvaub_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"68L3VRuvaub_IncorrectReview","id":"01","linkId":"68L3VRuvaub_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":409,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":29}}}],"shapemaskId":"","xPos":0,"yPos":365,"tabIndex":13,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":8,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":720,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":28}},"html5data":{"xPos":1,"yPos":1,"width":717,"height":37,"strokewidth":2}},"width":720,"height":40,"resume":false,"useHandCursor":true,"id":"68L3VRuvaub_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"61papgTo14k","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');
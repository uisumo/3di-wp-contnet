window.globalProvideData('slide', '{"title":"21.4 - Purpose Statement","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"5ey5Xz0wQu2","lmsId":"Slide10","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":0,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"69izh20Evxl","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"noteq","valuea":"5iHtqsr0EfL.$Text","typea":"property","valueb":"","typeb":"string"}},"thenActions":[{"kind":"eval_interaction","id":"_this.6LUMzBAL5vv"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_6KZmoH9OTKf.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_69izh20Evxl"}]},"ReviewInt_5wkYPJkT4Mm":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5iHtqsr0EfL"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_5wkYPJkT4Mm","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001010101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5wkYPJkT4Mm"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5wkYPJkT4Mm"}]}]}]},"ReviewIntCorrectIncorrect_5wkYPJkT4Mm":{"kind":"actiongroup","actions":[]},"AnsweredInt_5wkYPJkT4Mm":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_5wkYPJkT4Mm"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"DisableChoices_5wkYPJkT4Mm":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5iHtqsr0EfL"},"enabled":{"type":"boolean","value":false}}]},"5wkYPJkT4Mm_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6LUMzBAL5vv.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_5wkYPJkT4Mm"}]}]},"SetLayout_pxabnsnfns01001010101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"NavigationRestrictionNextSlide_69izh20Evxl":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.5nnSyv28G8M"}}]},"NavigationRestrictionPreviousSlide_69izh20Evxl":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001010101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_69izh20Evxl","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5wkYPJkT4Mm","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6KZmoH9OTKf","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6KZmoH9OTKf","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5wkYPJkT4Mm","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_5wkYPJkT4Mm"}],"elseActions":[{"kind":"exe_actiongroup","id":"5wkYPJkT4Mm_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_5wkYPJkT4Mm","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_5wkYPJkT4Mm","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_69izh20Evxl"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_69izh20Evxl"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_69izh20Evxl","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":5000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5s32tLSuq0i"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6axWeEUdJVY"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6axWeEUdJVY.65DgDp5ci5d"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6axWeEUdJVY.5XWQCbyMM12"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5iHtqsr0EfL"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5ctX9UUt7Ez"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":23,"id":"01","url":"story_content/6VruzymmEfE_X_80_DX1998_DY1998.swf","type":"normal","altText":"lens_flare.png","width":1920,"height":1078,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":1,"yPos":1,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":77}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"5s32tLSuq0i"},{"kind":"objgroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":13,"id":"01","url":"story_content/5qTVF62eiau_80_DX1998_DY1998.swf","type":"normal","altText":"objectives.png","width":1920,"height":301,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":8,"yPos":8,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":78.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":157,"altText":"objectives.png","pngfb":false,"pr":{"l":"Lib","i":1}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":157,"strokewidth":0}},"width":999,"height":157,"resume":true,"useHandCursor":true,"id":"65DgDp5ci5d"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5XWQCbyMM12_-1239841694","id":"01","linkId":"txt__default_5XWQCbyMM12","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":835,"bottom":138,"pngfb":false,"pr":{"l":"Lib","i":237}}}],"shapemaskId":"","xPos":58,"yPos":12,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":450,"rotateYPos":72,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":900,"bottom":144,"altText":"Putting it all together: Write a single sentence (170 characters or less) using your verb, target, and outcome which incorporates your core values.","pngfb":false,"pr":{"l":"Lib","i":236}},"html5data":{"xPos":-1,"yPos":-1,"width":901,"height":145,"strokewidth":0}},"width":900,"height":144,"resume":true,"useHandCursor":true,"id":"5XWQCbyMM12"}],"accType":"text","altText":"Group\\r\\n 1","shapemaskId":"","xPos":-8,"yPos":-8,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":507.5,"rotateYPos":86.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"width":1015,"height":173,"resume":true,"useHandCursor":true,"id":"6axWeEUdJVY"},{"kind":"textinput","bindto":"_player.TextEntry7","align":"left","rtl":false,"numeric":false,"multiline":true,"maxchars":170,"placeholder":"type your text here","fontsize":23,"textcolor":"0x000000","bold":false,"font":"+minor","baseFontFamily":"","baseFontStyle":"+minor","marginleft":13,"marginright":13,"margintop":0,"marginbottom":0,"shapemaskId":"","xPos":50,"yPos":236,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":449.5,"rotateYPos":138.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"5iHtqsr0EfL","linkId":"","type":"vectortext","xPos":13,"yPos":6,"width":873,"height":277,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":196,"bottom":30,"pngfb":false,"pr":{"l":"Lib","i":239}}},"html5data":{"xPos":-1,"yPos":-1,"width":901,"height":279,"strokewidth":1}},"width":900,"height":278,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":-1,"top":-1,"right":901,"bottom":279,"altText":"type your text here","pngfb":false,"pr":{"l":"Lib","i":238}}},"id":"5iHtqsr0EfL","events":[{"kind":"onlosefocus","actions":[{"kind":"adjustvar","variable":"_player.TextEntry7","operator":"set","value":{"type":"property","value":"$Text"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5ctX9UUt7Ez_1670124406","id":"01","linkId":"txt__default_5ctX9UUt7Ez","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":548,"bottom":40,"pngfb":false,"pr":{"l":"Lib","i":241}}}],"shapemaskId":"","xPos":36,"yPos":172,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":300,"rotateYPos":23,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":600,"bottom":46,"altText":"My Transformational Purpose in coaching is:","pngfb":false,"pr":{"l":"Lib","i":240}},"html5data":{"xPos":-1,"yPos":-1,"width":601,"height":47,"strokewidth":0}},"width":600,"height":46,"resume":true,"useHandCursor":true,"id":"5ctX9UUt7Ez"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5wkYPJkT4Mm_CorrectReview","id":"01","linkId":"5wkYPJkT4Mm_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":56}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":55}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"5wkYPJkT4Mm_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5wkYPJkT4Mm_IncorrectReview","id":"01","linkId":"5wkYPJkT4Mm_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":58}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":7,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":57}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"5wkYPJkT4Mm_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"5ey5Xz0wQu2","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');
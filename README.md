# Speech-Analyst
The goal of this project was to collect speeches using an android app and then convert it into text for further analysis. The android app also 
tracks user geographical position so that it can automatically find out the location from where the speech was uploaded. To convert the speech into text
google STT API was used.

**Publication:** https://link.springer.com/chapter/10.1007/978-981-15-6584-7_6

**Online Live Demo:** https://speechanalyst.com/cuetsr/


## Screenshots of the website
**Android App:**
<br>
First you need to register an account and then login. After successful login you will be directed to the dashboard page.
<br>
Registration             |  Sign In         | Dashboard 
:-------------------------:|:-------------------------:|:-------------------------:
<img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Android/registration.jpg" width="250">  |  <img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Android/sign_in.jpg" width="250">  |  <img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Android/home_page.jpg" width="250">

<br>
Now you can directly upload the speech or record a new speech. Then after filling up the appropriate information you can upload it to the server.
<br>

Upload Speech             |  Record Speech        
:-------------------------:|:-------------------------:
<img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Android/upload_file.jpg" width="250">  |  <img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Android/record_upload.jpg" width="250">

**Website:**
<br>After uploading the speech, your speech will be available in the website where it will be ready for processing. Only admin can see the processed text. We have also analzed the text to find out if the speech contains any suspicious contents or not. For this we have used LSTM network.<br>

Repository Home Page         
:-------------------------:|
<img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Website/home_rep.PNG">  |  

Speech Details         
:-------------------------:|
<img src="https://github.com/bi11a1/Speech-Analyst/blob/main/Demo/Website/show_speech_admin.PNG"> |

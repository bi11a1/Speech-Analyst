import sys
import os

#print(sys.path)
sys.path.append("/usr/local/lib/python3.7/site-packages")
#print(sys.path)

#pydub.AudioSegment.ffmpeg = "/home/bitnami/.local/bin/ffmpeg"
import speech_recognition as sr
from pydub import AudioSegment
from pydub.utils import make_chunks


folder_location = "android/files/";
chunk_location = "chunk/"

def convert_to_text(file_name, language):
	myaudio = AudioSegment.from_file(folder_location+file_name) # Reading audio file
	chunk_length_ms = 90000 # pydub calculates in millisec
	chunks = make_chunks(myaudio, chunk_length_ms) #Make chunks of chunk_length_ms sec

	# text1 = "English: "
	# text2 = "Bangla: "
	# text3 = "Arabic: "
	final_text = ""

	if(language.lower() == "english"): language = "en-US"
	elif(language.lower() == "arabic"): language.lower() == "ar-SA"
	else: language = "bn-BD"

	r = sr.Recognizer()
	for i, chunk in enumerate(chunks):
	    # chunk_name = "chunk{0}.wav".format(i)
	    chunk_name = "chunk.wav"
	    # print("exporting", chunk_name)
	    chunk.export(chunk_location+chunk_name, format="wav")
	    with sr.WavFile(chunk_location+chunk_name) as source:     # mention source as audio files.
	        audio = r.listen(source)
	        try:
	            text = r.recognize_google(audio, language = language, show_all=False)
	        except:
	            text = ""
	        final_text = final_text + "\n" + text

	    # with sr.WavFile("new_chunks/"+chunk_name) as source:     # mention source as audio files.
	    #     audio = r.listen(source)
	    #     try:
	    #         text = r.recognize_google(audio, language = "bn-BD", show_all=False)
	    #     except:
	    #         text = ""
	    #     text2 = text2 + "\n" + text

	    # with sr.WavFile("new_chunks/"+chunk_name) as source:     # mention source as audio files.
	    #     audio = r.listen(source)
	    #     try:
	    #         text = r.recognize_google(audio, language = "ar-SA", show_all=False)
	    #     except:
	    #         text = ""
	    #     text3 = text3 + "\n" + text

	text_file_name = file_name[:-3] + "txt"	# Saving the text file: same name as audio file

	with open(folder_location + text_file_name, "w", encoding="utf-8") as myfile: # The bangla text is saved in text.txt file
	    myfile.write(final_text)

if __name__ == "__main__":
	# Arguments passed when executing this file
	# First argument should be file_name
	# Second argument should be the language
	# code.py file_name language
	arg = sys.argv[1:]
	file_name = arg[0]
	language = arg[1]

	convert_to_text(file_name, language);
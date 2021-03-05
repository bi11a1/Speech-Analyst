import sys
import os
import pickle

sys.path.append("/usr/local/lib/python3.7/site-packages")
#print(sys.path)

import speech_recognition as sr
from pydub import AudioSegment
from pydub.utils import make_chunks

import tensorflow as tf
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from tensorflow.keras.models import Model



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
	elif(language.lower() == "arabic"): language = "ar-SA"
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

	# Sus/No-sus detection
	# Can detect only Bangla
	if(language != "bn-BD"): return

	file = open(folder_location + text_file_name, 'r', encoding = 'utf-8')
	text_data = file.read()
	load_model = tf.keras.models.load_model('suspicious/detector.h5')
	with open('suspicious/tokenizer.pickle', 'rb') as handle:
	    tokenizer = pickle.load(handle)

	max_length = 200
	trunc_type='post'
	padding_type='post'
	test_sentences = [text_data]
	sequences = tokenizer.texts_to_sequences(test_sentences)
	# print(sequences)
	padded = pad_sequences(sequences, maxlen=max_length, padding=padding_type, truncating=trunc_type)
	op_prediction = load_model.predict(padded)
	prediction = op_prediction[0][0]
	# print(prediction)
	print(int(round(prediction)))

if __name__ == "__main__":
	# Arguments passed when executing this file
	# First argument should be file_name
	# Second argument should be the language
	# code.py file_name language
	arg = sys.argv[1:]
	file_name = arg[0]
	language = arg[1]

	convert_to_text(file_name, language);
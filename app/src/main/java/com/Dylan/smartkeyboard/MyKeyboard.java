package com.dylan.smartkeyboard;

import android.inputmethodservice.InputMethodService;
import android.view.View;
import android.widget.Button;

import java.io.FileOutputStream;

public class MyKeyboard extends InputMethodService {

    @Override
    public View onCreateInputView() {
        View view = getLayoutInflater().inflate(R.layout.keyboard, null);

        Button btnA = view.findViewById(R.id.btnA);
        Button btnEmoji = view.findViewById(R.id.btnEmoji);
        Button btnSpace = view.findViewById(R.id.btnSpace);

        btnA.setOnClickListener(v -> writeKey("a"));
        btnEmoji.setOnClickListener(v -> writeKey("😊"));
        btnSpace.setOnClickListener(v -> writeKey(" "));

        return view;
    }

    private void writeKey(String text) {
        getCurrentInputConnection().commitText(text, 1);
        saveToFile(text);
    }

    private void saveToFile(String text) {
        try {
            FileOutputStream fos = openFileOutput("sauvegarde.txt", MODE_APPEND);
            fos.write((text).getBytes());
            fos.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}

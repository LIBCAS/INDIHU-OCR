package cz.inqool.uas.orc;

import net.sourceforge.tess4j.ITesseract;
import net.sourceforge.tess4j.Tesseract;
import net.sourceforge.tess4j.TesseractException;
import org.apache.commons.io.FilenameUtils;
import org.apache.commons.io.IOUtils;
import org.springframework.core.io.FileSystemResource;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.nio.file.Files;
import java.util.ArrayList;
import java.util.List;
import java.util.UUID;

@RestController
@RequestMapping
public class OcrApi {
    @Deprecated
    @RequestMapping(method = RequestMethod.POST, path = "toSearchablePdf")
    public ResponseEntity<FileSystemResource> toSearchablePdf(
            @RequestParam("file") MultipartFile uploadFile,
            @RequestParam(name = "lang", defaultValue = "eng") String lang
    ) throws IOException, TesseractException {
        File tempInputFile = Files.createTempFile(UUID.randomUUID().toString(), null).toFile();
        File tempOutputFile = Files.createTempFile(UUID.randomUUID().toString(), ".pdf").toFile();
        String filename = uploadFile.getOriginalFilename();
        try (InputStream inputStream = uploadFile.getInputStream()) {
            if (filename != null) {
                filename = FilenameUtils.getName(filename);
            }
            try(FileOutputStream fos = new FileOutputStream(tempInputFile)) {
                IOUtils.copy(inputStream, fos);
            }
        }
        ITesseract instance = new Tesseract();
        List<ITesseract.RenderedFormat> list = new ArrayList<>();
        list.add(ITesseract.RenderedFormat.PDF);
        instance.setLanguage(lang);
        instance.setDatapath("./tessdata");
        String tempOutputFileNoExtension = tempOutputFile.getAbsolutePath().substring(0, tempOutputFile.getAbsolutePath().length() - 4);
        instance.createDocuments(tempInputFile.getAbsolutePath(), tempOutputFileNoExtension, list);
        return ResponseEntity
                .ok()
                .header("Content-Disposition", "attachment; filename=" + filename)
                .header("Content-Length", String.valueOf(tempOutputFile.length()))
                .contentType(MediaType.APPLICATION_PDF)
                .body(new FileSystemResource(tempOutputFile));
    }

    @RequestMapping(method = RequestMethod.POST, path = "ocr")
    public ResponseEntity<FileSystemResource> doOcr(
            @RequestParam("file") MultipartFile uploadFile,
            @RequestParam(name = "lang", defaultValue = "eng") String lang,
            @RequestParam(name = "format", defaultValue = "pdf") Format format
    ) throws IOException, TesseractException {
        File tempInputFile = Files.createTempFile(UUID.randomUUID().toString(), null).toFile();
        File tempOutputFile = Files.createTempFile(UUID.randomUUID().toString(), "." + format).toFile();
        String filename = uploadFile.getOriginalFilename();
        try (InputStream inputStream = uploadFile.getInputStream()) {
            if (filename != null) {
                filename = FilenameUtils.getName(filename);
            }
            try(FileOutputStream fos = new FileOutputStream(tempInputFile)) {
                IOUtils.copy(inputStream, fos);
            }
        }
        ITesseract instance = new Tesseract();
        List<ITesseract.RenderedFormat> list = new ArrayList<>();
        list.add(getRenderedFormatForFormat(format));
        instance.setLanguage(lang);
        instance.setDatapath("./tessdata");
        String tempOutputFileNoExtension = tempOutputFile.getAbsolutePath().substring(0, tempOutputFile.getAbsolutePath().length() - format.name().length() - 1);
        instance.createDocuments(tempInputFile.getAbsolutePath(), tempOutputFileNoExtension, list);
        return ResponseEntity
                .ok()
                .header("Content-Disposition", "attachment; filename=" + filename)
                .header("Content-Length", String.valueOf(tempOutputFile.length()))
                .contentType(getMimeForFormat(format))
                .body(new FileSystemResource(tempOutputFile));
    }

    private enum Format {
        pdf,
        txt
    }

    private MediaType getMimeForFormat(Format format) {
        switch (format) {
            case pdf:
                return MediaType.APPLICATION_PDF;
            case txt:
                return MediaType.TEXT_PLAIN;
            default:
                throw new RuntimeException("Unsupported data format: " + format);
        }
    }

    private ITesseract.RenderedFormat getRenderedFormatForFormat(Format format) {
        switch (format) {
            case pdf:
                return ITesseract.RenderedFormat.PDF;
            case txt:
                return ITesseract.RenderedFormat.TEXT;
            default:
                throw new RuntimeException("Unsupported data format: " + format);
        }
    }
}
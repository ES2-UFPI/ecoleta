import { StyleSheet, View } from 'react-native';
import PickerSelect from 'react-native-picker-select';

export function PickerInput({ label, itens, onValueChange, value }) {
    return (
        <View style={styles.container}>
            <PickerSelect
                placeholder={{ label, value: '', color: '#999' }}
                onValueChange={onValueChange}
                value={value}
                items={itens}
                useNativeAndroidPickerStyle={false}
                style={{
                    inputAndroid: {
                        color: '#ccc',
                        width: 300,
                        marginLeft: 15,
                    },
                    inputIOSContainer: { marginLeft: 15, width: 300 },
                    viewContainer: {
                        flex: 1,
                        justifyContent: 'center',
                    },
                    placeholder: {
                        color: '#999',
                    },
                }}
            />
        </View>
    )
}

const styles = StyleSheet.create({
    container: {
        height: 50,
        borderWidth: 1,
        borderColor: '#333',
        marginBottom: 20,
        borderRadius: 4
    },
});